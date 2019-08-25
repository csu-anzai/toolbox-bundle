<?php

namespace Atournayre\ToolboxBundle\Subscribers;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Atournayre\ToolboxBundle\Encryptor\EncryptorInterface;
use Atournayre\ToolboxBundle\Annotations\Encrypted;
use Exception;
use ReflectionProperty;

class DoctrineEncryptSubscriber implements EventSubscriber, DoctrineEncryptSubscriberInterface
{
    /**
     * Encryptor interface namespace
     */
    const ENCRYPTOR_INTERFACE_NS = EncryptorInterface::class;

    /**
     * An array of annotations which are to be encrypted.
     * The default and initial is the bundle Encrypted Class.
     *
     * @var array
     */
    protected $annotationArray;

    /**
     * Encryptor
     *
     * @var EncryptorInterface
     */
    protected $encryptor;

    /**
     * Annotation reader
     *
     * @var Reader
     */
    protected $annotationReader;

    /**
     * Registr to avoid multi decode operations for one entity
     *
     * @var array
     */
    private $decodedRegistry = [];

    /**
     * Caches information on an entity's encrypted fields in an array keyed on
     * the entity's class name. The value will be a list of Reflected fields that are encrypted.
     *
     * @var array
     */
    protected $encryptedFieldCache = [];

    /**
     * Before flushing the objects out to the database, we modify their password value to the
     * encrypted value. Since we want the password to remain decrypted on the entity after a flush,
     * we have to write the decrypted value back to the entity.
     *
     * @var array
     */
    private $postFlushDecryptQueue = [];

    /**
     * @var bool
     */
    private $isDisabled;

    /**
     * DoctrineEncryptSubscriber constructor.
     *
     * @param Reader             $annotationReader
     * @param EncryptorInterface $encryptor
     * @param array              $annotationArray
     * @param bool               $isDisabled
     */
    public function __construct(
        Reader $annotationReader,
        EncryptorInterface $encryptor,
        array $annotationArray,
        bool $isDisabled
    ) {
        $this->annotationReader = $annotationReader;
        $this->encryptor = $encryptor;
        $this->annotationArray = $annotationArray;
        $this->isDisabled = $isDisabled;
    }

    /**
     * Return the encryptor.
     *
     * @return EncryptorInterface
     */
    public function getEncryptor(): EncryptorInterface
    {
        return $this->encryptor;
    }

    /**
     * Set Is Disabled
     *
     * Used to programmatically disable encryption on flush operations.
     * Decryption still occurs if values have the <ENC> suffix.
     *
     * @param bool $isDisabled
     *
     * @return $this
     */
    public function setIsDisabled($isDisabled = true): self
    {
        $this->isDisabled = $isDisabled;

        return $this;
    }

    /**
     * Realization of EventSubscriber interface method.
     *
     * @return array Return all events which this subscriber is listening
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::postLoad,
            Events::onFlush,
            Events::postFlush,
        ];
    }

    /**
     * Encrypt the password before it is written to the database.
     *
     * Notice that we do not recalculate changes otherwise the password will be written
     * every time (Because it is going to differ from the un-encrypted value)
     *
     * @param OnFlushEventArgs $args
     *
     * @throws Exception
     */
    public function onFlush(OnFlushEventArgs $args): void
    {
        if ($this->isDisabled) {
            return;
        }

        $em = $args->getEntityManager();
        $unitOfWork = $em->getUnitOfWork();

        $this->postFlushDecryptQueue = [];

        foreach ($unitOfWork->getScheduledEntityInsertions() as $entity) {
            $this->entityOnFlush($entity, $em);
            $unitOfWork->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($entity)), $entity);
        }

        foreach ($unitOfWork->getScheduledEntityUpdates() as $entity) {
            $this->entityOnFlush($entity, $em);
            $unitOfWork->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($entity)), $entity);
        }
    }

    /**
     * Processes the entity for an onFlush event.
     *
     * @param               $entity
     * @param EntityManager $em
     *
     * @throws Exception
     */
    protected function entityOnFlush($entity, EntityManager $em): void
    {
        if ($this->isDisabled) {
            return;
        }

        $objId = spl_object_hash($entity);

        $fields = [];
        foreach ($this->getEncryptedFields($entity, $em) as $field) {
            $fields[$field->getName()] = [
                'field' => $field,
                'value' => $field->getValue($entity),
            ];
        }

        $this->postFlushDecryptQueue[$objId] = [
            'entity' => $entity,
            'fields' => $fields,
        ];

        $this->processFields($entity, $em);
    }

    /**
     * After we have persisted the entities, we want to have the
     * decrypted information available once more.
     *
     * @param PostFlushEventArgs $args
     */
    public function postFlush(PostFlushEventArgs $args): void
    {
        if ($this->isDisabled) {
            return;
        }

        $unitOfWork = $args->getEntityManager()
            ->getUnitOfWork();

        foreach ($this->postFlushDecryptQueue as $pair) {
            $fieldPairs = $pair['fields'];
            $entity = $pair['entity'];
            $oid = spl_object_hash($entity);

            foreach ($fieldPairs as $fieldPair) {
                /** @var \ReflectionProperty $field */
                $field = $fieldPair['field'];

                $field->setValue($entity, $fieldPair['value']);
                $unitOfWork->setOriginalEntityProperty($oid, $field->getName(), $fieldPair['value']);
            }

            $this->addToDecodedRegistry($entity);
        }

        $this->postFlushDecryptQueue = [];
    }

    /**
     * Listen a postLoad lifecycle event. Checking and decrypt entities
     * which have @Encrypted annotations
     *
     * @param LifecycleEventArgs $args
     *
     * @throws Exception
     */
    public function postLoad(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if (!$this->hasInDecodedRegistry($entity)) {
            if ($this->processFields($entity, $em, false)) {
                $this->addToDecodedRegistry($entity);
            }
        }
    }

    /**
     * Decrypt a value.
     *
     * If the value is an object, or if it does not contain the suffic <ENC> then return the value iteslf back.
     * Otherwise, decrypt the value and return.
     *
     * @param string $value
     *
     * @return string
     */
    public function decryptValue(string $value): string
    {
        return $this->encryptor->decrypt($value);
    }

    /**
     * @param array $allProperties
     *
     * @return array
     */
    public function getEncryptionableProperties(array $allProperties): array
    {
        $encryptedFields = [];

        foreach ($allProperties as $refProperty) {
            /** @var ReflectionProperty $refProperty */
           foreach ($this->annotationReader->getPropertyAnnotations($refProperty) as $key => $annotation) {
                if (in_array(get_class($annotation), $this->annotationArray)) {
                    $refProperty->setAccessible(true);
                    $encryptedFields[] = $refProperty;
                }
            }
        }

        return $encryptedFields;
    }

    /**
     * Process (encrypt/decrypt) entities fields
     *
     * @param               $entity
     * @param EntityManager $em
     * @param bool          $isEncryptOperation
     *
     * @return bool
     * @throws Exception
     */
    protected function processFields($entity, EntityManager $em, $isEncryptOperation = true): bool
    {
        $properties = $this->getEncryptedFields($entity, $em);

        $unitOfWork = $em->getUnitOfWork();
        $oid = spl_object_hash($entity);

        foreach ($properties as $refProperty) {
            $value = $refProperty->getValue($entity);
            if (null === $value) {
                continue;
            }

            if (is_object($value)) {
                throw new Exception('You cannot encrypt an object at ' . $refProperty->class . ':'. $refProperty->getName());
            }

            if ($isEncryptOperation) {
                $encryptedValue = $this->encryptor->encrypt($value);
                $refProperty->setValue($entity, $encryptedValue);
            } else {
                $decryptedValue = $this->decryptValue($value);
                $refProperty->setValue($entity, $decryptedValue);
                $unitOfWork->setOriginalEntityProperty($oid, $refProperty->getName(), $value);
            }
        }

        return !empty($properties);
    }


    /**
     * Check if we have entity in decoded registry
     *
     * @param object $entity Some doctrine entity
     *
     * @return boolean
     */
    protected function hasInDecodedRegistry($entity): bool
    {
        return isset($this->decodedRegistry[spl_object_hash($entity)]);
    }

    /**
     * Adds entity to decoded registry
     *
     * @param object $entity Some doctrine entity
     */
    protected function addToDecodedRegistry($entity): void
    {
        $this->decodedRegistry[spl_object_hash($entity)] = true;
    }

    /**
     * @param               $entity
     * @param EntityManager $em
     *
     * @return ReflectionProperty[]
     */
    protected function getEncryptedFields($entity, EntityManager $em): array
    {
        $className = get_class($entity);

        if (isset($this->encryptedFieldCache[$className])) {
            return $this->encryptedFieldCache[$className];
        }

        $meta = $em->getClassMetadata($className);

        $encryptedFields = [];

        foreach ($meta->getReflectionProperties() as $refProperty) {
            /** @var ReflectionProperty $refProperty */
            foreach ($this->annotationReader->getPropertyAnnotations($refProperty) as $key => $annotation) {
                if (in_array(get_class($annotation), $this->annotationArray)) {
                    $refProperty->setAccessible(true);
                    $encryptedFields[] = $refProperty;
                }
            }
        }

        $this->encryptedFieldCache[$className] = $encryptedFields;

        return $encryptedFields;
    }
}
