<?php

namespace Atournayre\ToolboxBundle\Tests\Number;

use Atournayre\ToolboxBundle\Service\Number\NumberNullable;
use Exception;
use PHPUnit\Framework\TestCase;

class NumberNullableTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testNullToFloat()
    {
        $number = new NumberNullable();
        $this->assertEquals(0, $number->intToFloat(null));
    }

    /**
     * @throws Exception
     */
    public function testNullToInt()
    {
        $number = new NumberNullable();
        $this->assertEquals(0, $number->floatToInt(null));
    }
}
