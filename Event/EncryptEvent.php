<?php

namespace Atournayre\ToolboxBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class EncryptEvent extends Event implements EncryptEventInterface
{
    /**
     * The string / object to be encrypted or decrypted.
     *
     * @var string
     */
    protected $value;

    /**
     * EncryptEvent constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value= $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
