<?php

namespace Atournayre\ToolboxBundle\Service\Number;

interface NumberInterface
{
    /**
     * @param mixed $integer
     *
     * @return float
     */
    public function intToFloat($integer): float;

    /**
     * @param mixed $float
     *
     * @return int
     */
    public function floatToInt($float): int;

}
