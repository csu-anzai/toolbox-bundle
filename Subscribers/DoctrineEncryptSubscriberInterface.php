<?php

namespace Atournayre\ToolboxBundle\Subscribers;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Atournayre\ToolboxBundle\Encryptor\EncryptorInterface;
use Atournayre\ToolboxBundle\Annotations\Encrypted;

interface DoctrineEncryptSubscriberInterface
{
    const ENCRYPTED_SUFFIX = '<ENC>';

    public function __construct(
        Reader $annotationReader,
        EncryptorInterface $encryptor,
        array $annotationArray,
        bool $isDisabled
    );

    /**
     * Encrypt the password before it is written to the database.
     *
     * Notice that we do not recalculate changes otherwise the value will be written
     * every time (Because it is going to differ from the un-encrypted value)
     *
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args): void;

    /**
     * After we have persisted the entities, we want to have the
     * decrypted information available once more.
     *
     * @param PostFlushEventArgs $args
     */
    public function postFlush(PostFlushEventArgs $args): void;

    /**
     * Listen a postLoad lifecycle event. Checking and decrypt entities
     * which have @Encrypted annotations
     *
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args): void;

    /**
     * Realization of EventSubscriber interface method.
     * @return array Return all events which this subscriber is listening
     */
    public function getSubscribedEvents(): array;
}
