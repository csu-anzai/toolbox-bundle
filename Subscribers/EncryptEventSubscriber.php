<?php

namespace Atournayre\ToolboxBundle\Subscribers;

use Atournayre\ToolboxBundle\Encryptor\EncryptorInterface;
use Atournayre\ToolboxBundle\Event\EncryptEventInterface;
use Atournayre\ToolboxBundle\Event\EncryptEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EncryptEventSubscriber implements EventSubscriberInterface
{
    /**
     * Encryptor created by the factory service.
     *
     * @var EncryptorInterface
     */
    protected $encryptor;

    /**
     * Store if the encryption is enabled or disabled in config.
     *
     * @var boolean
     */
    private $isDisabled;

    /**
     * EncryptEventSubscriber constructor.
     *
     * @param EncryptorInterface $encryptor
     * @param bool               $isDisabled
     */
    public function __construct(EncryptorInterface $encryptor, bool $isDisabled)
    {
        $this->encryptor = $encryptor;
        $this->isDisabled = $isDisabled;
    }

    /**
     * Realization of EventSubscriber interface method.
     *
     * @return array Return all events which this subscriber is listening
     */
    public static function getSubscribedEvents(): array
    {
        return [
            EncryptEvents::ENCRYPT => 'encrypt',
            EncryptEvents::DECRYPT => 'decrypt',
        ];
    }

    /**
     * Use an Encrypt even to encrypt a value.
     *
     * @param EncryptEventInterface $event
     *
     * @return EncryptEventInterface
     */
    public function encrypt(EncryptEventInterface $event): EncryptEventInterface
    {
        $value = $event->getValue();

        if (false === $this->isDisabled) {
            $value = $this->encryptor->encrypt($value);
        }

        $event->setValue($value);

        return $event;
    }

    /**
     * Use a decrypt event to decrypt a single value.
     *
     * @param EncryptEventInterface $event
     *
     * @return EncryptEventInterface
     */
    public function decrypt(EncryptEventInterface $event): EncryptEventInterface
    {
        $value = $event->getValue();
        $decrypted = $this->encryptor->decrypt($value);
        $event->setValue($decrypted);
        return $event;
    }
}
