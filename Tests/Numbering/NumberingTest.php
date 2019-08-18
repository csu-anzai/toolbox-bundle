<?php

namespace Atournayre\ToolboxBundle\Tests\Numbering;

use Atournayre\ToolboxBundle\Service\Numbering\Numbering;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class NumberingTest extends TestCase
{
    public function testIncrementNullReturn1()
    {
        $numbering = new Numbering();
        $this->assertEquals(1, $numbering->increment(null));
    }

    public function testIncrement0Return1()
    {
        $numbering = new Numbering();
        $this->assertEquals(1, $numbering->increment(0));
    }

    public function testIncrement1Return2()
    {
        $numbering = new Numbering();

        $this->assertEquals(2, $numbering->increment(1));
    }

    public function testPrefixNumber()
    {
        $numbering = new Numbering();
        $this->assertEquals('PREFIXNUMBER', $numbering->prefix('NUMBER', 'PREFIX'));
    }

    public function testSuffixNumber()
    {
        $numbering = new Numbering();
        $this->assertEquals('NUMBERSUFFIX', $numbering->suffix('NUMBER', 'SUFFIX'));
    }

    public function testAdd4LeadingZeros()
    {
        $numbering = new Numbering(8, '0',STR_PAD_LEFT);
        $this->assertEquals('0000TEST', $numbering->pad('TEST'));
    }

    public function testAdd4EndingZeros()
    {
        $numbering = new Numbering(8, '0',STR_PAD_RIGHT);
        $this->assertEquals('TEST0000', $numbering->pad('TEST'));
    }

    public function testAdd4LeadingZerosAnd4EndingZeros()
    {
        $numbering = new Numbering(12, '0',STR_PAD_BOTH);
        $this->assertEquals('0000TEST0000', $numbering->pad('TEST'));
    }

    public function testAddNothingToNumber()
    {
        $numbering = new Numbering();
        $this->assertEquals('TEST', $numbering->pad('TEST'));
    }

    public function testPrefixAndAdd4LeadingZero()
    {
        $numbering = new Numbering(8, '0', STR_PAD_LEFT, 'PREFIX_');
        $this->assertEquals('PREFIX_0000TEST', $numbering->number('TEST'));
    }

    public function testPrefixAndAdd4EndingZero()
    {
        $numbering = new Numbering(8, '0', STR_PAD_RIGHT, 'PREFIX_');
        $this->assertEquals('PREFIX_TEST0000', $numbering->number('TEST'));
    }

    public function testSuffixAndAdd4LeadingZero()
    {
        $numbering = new Numbering(8, '0', STR_PAD_LEFT, null, '_SUFFIX');
        $this->assertEquals('0000TEST_SUFFIX', $numbering->number('TEST'));
    }

    public function testSuffixAndAdd4EndingZero()
    {
        $numbering = new Numbering(8, '0', STR_PAD_RIGHT, null, '_SUFFIX');
        $this->assertEquals('TEST0000_SUFFIX', $numbering->number('TEST'));
    }

    public function testPrefixAndSuffixAndAdd4LeadingZero()
    {
        $numbering = new Numbering(8, '0', STR_PAD_LEFT, 'PREFIX_', '_SUFFIX');
        $this->assertEquals('PREFIX_0000TEST_SUFFIX', $numbering->number('TEST'));
    }

    public function testPrefixAndSuffixAndAdd4LeadingAnd4EndingZero()
    {
        $numbering = new Numbering(12, '0', STR_PAD_BOTH, 'PREFIX_', '_SUFFIX');
        $this->assertEquals('PREFIX_0000TEST0000_SUFFIX', $numbering->number('TEST'));
    }
}
