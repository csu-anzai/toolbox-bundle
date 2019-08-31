<?php

namespace Atournayre\ToolboxBundle\Service\Calculation;

class Calculation
{
    /**
     * @param int|float|null $number
     *
     * @return float|null
     */
    public function invertSign($number): ?float
    {
        return empty($number) ? null : -1 * $number;
    }
}
