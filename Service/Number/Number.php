<?php

namespace Atournayre\ToolboxBundle\Service\Number;

use Exception;

class Number extends AbstractNumber implements NumberInterface
{
    /**
     * @param mixed $integer
     *
     * @return float
     * @throws Exception
     */
    public function intToFloat($integer): float
    {
        $this->throwIntegerIsNullException($integer);
        return parent::intToFloat($integer);
    }

    /**
     * @param mixed $float
     *
     * @return int
     * @throws Exception
     */
    public function floatToInt($float): int
    {
        $this->throwFloatIsNullException($float);
        return parent::floatToInt($float);
    }
}
