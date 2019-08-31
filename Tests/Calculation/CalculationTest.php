<?php

namespace Atournayre\ToolboxBundle\Tests\Calculation;

use Atournayre\ToolboxBundle\Service\Calculation\Calculation;
use PHPUnit\Framework\TestCase;

class CalculationTest extends TestCase
{
    public function testRevertIntegerSignOfPlusOne()
    {
        $calculation = new Calculation();
        $this->assertEquals(-1, $calculation->invertSign(1));
    }

    public function testRevertFloatSignOfPlusOneFloat()
    {
        $calculation = new Calculation();
        $this->assertEquals(-1.12, $calculation->invertSign(1.12));
    }

    public function testRevertNull()
    {
        $calculation = new Calculation();
        $this->assertNull($calculation->invertSign(null));
    }

    public function testRevertEmptyString()
    {
        $calculation = new Calculation();
        $this->assertNull($calculation->invertSign(''));
    }

    public function testRevertIntegerSignOfMinusOne()
    {
        $calculation = new Calculation();
        $this->assertEquals(1, $calculation->invertSign(-1));
    }

    public function testRevertFloatSignOfMinusOneFloat()
    {
        $calculation = new Calculation();
        $this->assertEquals(1.133, $calculation->invertSign(-1.133));
    }
}
