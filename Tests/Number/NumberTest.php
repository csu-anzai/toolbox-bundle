<?php

namespace Atournayre\ToolboxBundle\Tests\Number;

use Atournayre\ToolboxBundle\Service\Number\Number;
use Exception;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    public function testIntegerToFloat()
    {
        $number = new Number();
        $this->assertEquals(12.34, $number->intToFloat(1234));
    }

    /**
     * @throws Exception
     */
    public function testFloatToInt()
    {
        $number = new Number();
        $this->assertEquals(1234, $number->floatToInt(12.34));
    }

    /**
     * @throws Exception
     */
    public function testIntToInt()
    {
        $this->expectException(Exception::class);
        $number = new Number();
        $number->floatToInt(1000);
    }

    /**
     * @throws Exception
     */
    public function testFloatToFloat()
    {
        $this->expectException(Exception::class);
        $number = new Number();
        $number->intToFloat(10.00);
    }

    /**
     * @throws Exception
     */
    public function testNullToInt()
    {
        $this->expectException(Exception::class);
        $number = new Number();
        $number->floatToInt(null);
    }

    /**
     * @throws Exception
     */
    public function testNullToFloat()
    {
        $this->expectException(Exception::class);
        $number = new Number();
        $number->intToFloat(null);
    }

}
