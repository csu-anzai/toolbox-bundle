<?php

namespace Atournayre\ToolboxBundle\Service\Address;

interface AddressInterface
{
    public function line(string $line): string;
}