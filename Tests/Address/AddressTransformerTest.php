<?php

namespace Atournayre\ToolboxBundle\Tests\Address;

use Atournayre\ToolboxBundle\Service\Address\AddressTransformer;
use PHPUnit\Framework\TestCase;

class AddressTransformerTest extends TestCase
{
    public function testBis()
    {
        $this->assertRegExp(AddressTransformer::PATTERN_BIS_AND_CO, '4 bis grand rue');
    }

    public function testBisError()
    {
        $this->assertNotRegExp(AddressTransformer::PATTERN_BIS_AND_CO, '4 nobis grand rue');
    }

    public function testBisError2()
    {
        $this->assertNotRegExp(AddressTransformer::PATTERN_BIS_AND_CO, '4 bisno grand rue');
    }

    public function testTer()
    {
        $this->assertRegExp(AddressTransformer::PATTERN_BIS_AND_CO, '4 ter grand rue');
    }

    public function testQuater()
    {
        $this->assertRegExp(AddressTransformer::PATTERN_BIS_AND_CO, '4 quater grand rue');
    }

    public function testConvertBis()
    {
        $addressTransformer = new AddressTransformer();
        $this->assertEquals('4 b grand rue', $addressTransformer->convertBisAndCo('4 bis grand rue'));
    }

    public function testConvertTer()
    {
        $addressTransformer = new AddressTransformer();
        $this->assertEquals('4 t grand rue', $addressTransformer->convertBisAndCo('4 ter grand rue'));
    }

    public function testConvertQuater()
    {
        $addressTransformer = new AddressTransformer();
        $this->assertEquals('4 q grand rue', $addressTransformer->convertBisAndCo('4 quater grand rue'));
    }

    public function testMulipleNumberPattern()
    {
        $this->assertRegExp(AddressTransformer::PATTERN_MULTIPLE_NUMBER, '4/6 grand rue');
    }

    public function testMulipleNumberPattern2()
    {
        $this->assertRegExp(AddressTransformer::PATTERN_MULTIPLE_NUMBER, '4 / 6 grand rue');
    }

    public function testMulipleNumberLetterPattern()
    {
        $this->assertRegExp(AddressTransformer::PATTERN_MULTIPLE_NUMBER, '4 à 6 grand rue');
    }

    public function testConvertMultipleNumber()
    {
        $addressTransformer = new AddressTransformer();
        $this->assertEquals('4 grand rue', $addressTransformer->convertMultipleNumbers('4/8 grand rue'));
    }

    public function testConvertMultipleNumber2()
    {
        $addressTransformer = new AddressTransformer();
        $this->assertEquals('4 grand rue', $addressTransformer->convertMultipleNumbers('4 / 8 grand rue'));
    }

    public function testConvertMultipleLetterNumber()
    {
        $addressTransformer = new AddressTransformer();
        $this->assertEquals('4 grand rue', $addressTransformer->convertMultipleNumbers('4 à8 grand rue'));
    }

    public function testCleanupPunctuation()
    {
        $addressTransformer = new AddressTransformer();
        $this->assertEquals('', $addressTransformer->cleanPunctuation('[.,\/#!$%\^&\*;:{}=\-_`~()]'));
    }

    public function testCleanupPunctuation2()
    {
        $addressTransformer = new AddressTransformer();
        $this->assertEquals('', $addressTransformer->cleanPunctuation('[.,\/#!$%\^\*;:{=\-_`)]'));
    }

    public function testFullCleanUp()
    {
        $addressTransformer = new AddressTransformer();
        $cleanup = $addressTransformer->cleanPunctuation('4 à 8, rue de l\'isle');
        $cleanup = $addressTransformer->convertBisAndCo($cleanup);
        $cleanup = $addressTransformer->convertMultipleNumbers($cleanup);
        $this->assertEquals('4 rue de l isle', $cleanup);
    }
}