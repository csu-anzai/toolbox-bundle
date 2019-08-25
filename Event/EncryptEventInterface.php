<?php

namespace Atournayre\ToolboxBundle\Event;

interface EncryptEventInterface
{
    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param string $value
     */
    public function setValue(string $value): void;
}
