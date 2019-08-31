<?php

namespace Atournayre\ToolboxBundle\Service\Number;

use Exception;

class AbstractNumber implements NumberInterface
{
    CONST EXCEPTION_MESSAGE = '%s method only accept %s, %s given.';

    /**
     * @param mixed $integer
     *
     * @return float
     * @throws Exception
     */
    public function intToFloat($integer): float
    {
        $this->throwIntegerIsFloatException($integer);
        return floatval($integer) / 100;
    }

    /**
     * @param mixed $float
     *
     * @return int
     * @throws Exception
     */
    public function floatToInt($float): int
    {
        $this->throwFloatIsIntegerException($float);
        return intval($float * 100);
    }

    /**
     * @param $integer
     *
     * @throws Exception
     */
    protected function throwIntegerIsNullException($integer): void
    {
        if (null === $integer) {
            throw new Exception(sprintf(self::EXCEPTION_MESSAGE, __METHOD__, 'integer', 'null'));
        }
    }

    /**
     * @param $integer
     *
     * @throws Exception
     */
    protected function throwIntegerIsFloatException($integer): void
    {
        if (is_float($integer)) {
            throw new Exception(sprintf(self::EXCEPTION_MESSAGE, __METHOD__, 'integer', 'float'));
        }
    }

    /**
     * @param $float
     *
     * @throws Exception
     */
    protected function throwFloatIsNullException($float): void
    {
        if (null === $float) {
            throw new Exception(sprintf(self::EXCEPTION_MESSAGE, __METHOD__, 'float', 'null'));
        }
    }

    /**
     * @param $float
     *
     * @throws Exception
     */
    protected function throwFloatIsIntegerException($float): void
    {
        if (is_int($float)) {
            throw new Exception(sprintf(self::EXCEPTION_MESSAGE, __METHOD__, 'float', 'integer'));
        }
    }
}
