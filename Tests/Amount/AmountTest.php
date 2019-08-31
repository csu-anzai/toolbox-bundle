<?php

namespace Atournayre\ToolboxBundle\Tests\Amount;

use Atournayre\ToolboxBundle\Service\Amount\Amount;
use Exception;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    public function testGetOutOfTaxes()
    {
        $amount = new Amount(12345, 0);
        $this->assertEquals(12345, $amount->getOutOfTaxes());
    }

    public function testValueAddedTax()
    {
        $amount = new Amount(1000, 20);
        $this->assertEquals(200, $amount->getValueAddedTax());
    }

    public function testTaxIncluded()
    {
        $amount = new Amount(1000, 20);
        $this->assertEquals(1200, $amount->getTaxIncluded());
    }

    public function testDiscount()
    {
        $amount = new Amount(1000, 0);
        $amount->setDiscount(100);
        $this->assertEquals(100, $amount->getDiscount());
    }

    public function testDiscountPercent()
    {
        $amount = new Amount(1000, 0);
        $amount->setDiscountPercent(1000);
        $this->assertEquals(1000, $amount->getDiscountPercent());
    }

    public function testDiscountIsNull()
    {
        $amount = new Amount(1000, 0);
        $this->assertNull($amount->getDiscount());
    }

    /**
     * @throws Exception
     */
    public function testDiscountedOutOfTaxesFromDiscount()
    {
        $amount = new Amount(1000, 0);
        $amount->setDiscount(100);
        $this->assertEquals(900, $amount->getDiscountedOutOfTaxes());
    }

    public function testDiscountPercentIsNull()
    {
        $amount = new Amount(1000, 0);
        $this->assertNull($amount->getDiscountPercent());
    }

    /**
     * @throws Exception
     */
    public function testDiscountedOutOfTaxesFromDiscountPercent()
    {
        $amount = new Amount(1000, 0);
        $amount->setDiscountPercent(1000);
        $this->assertEquals(900, $amount->getDiscountedOutOfTaxes());
    }

    public function testApplicableVATIsTrue()
    {
        $amount = new Amount(1000, 0);
        $this->assertTrue($amount->isApplicableVAT());
    }

    public function testApplicableVATIsFalse()
    {
        $amount = new Amount(1000);
        $this->assertFalse($amount->isApplicableVAT());
    }

    public function testAmount()
    {
        $amount = new Amount(1000);
        $this->assertEquals(1000, $amount->getAmount());
    }

    public function testDiscountedAmount()
    {
        $amount = new Amount(1000);
        $amount->setDiscount(100);
        $this->assertEquals(900, $amount->getDiscountedAmount());
    }

    /**
     * @throws Exception
     */
    public function testAmountParts()
    {
        $amount = new Amount(1000, 20);
        $this->assertEquals(1000, $amount->getOutOfTaxes());
        $this->assertEquals(200, $amount->getValueAddedTax());
        $this->assertEquals(1200, $amount->getTaxIncluded());
        $this->assertEquals(1000, $amount->getDiscountedOutOfTaxes());
    }

    public function testDiscountedAmountParts()
    {
        $amount = new Amount(1000);
        $this->assertEquals(1000, $amount->getDiscountedAmount());
        $this->assertEquals(1000, $amount->getAmount());
    }

    public function testGetDiscountInValueFromDiscountPercent()
    {
        $amount = new Amount(1000);
        $amount->setDiscount(100);
        $this->assertEquals(100, $amount->getDiscountInValue());
    }

    public function testGetDiscountInValueFromDiscountAmount()
    {
        $amount = new Amount(1000);
        $amount->setDiscountPercent(1000);
        $this->assertEquals(100, $amount->getDiscountInValue());
    }

    public function testGetDiscountInValueFromDiscountAmountWithTaxes()
    {
        $amount = new Amount(1000, 20);
        $amount->setDiscountPercent(1000);
        $this->assertEquals(100, $amount->getDiscountInValue());
    }

    public function testGetPartsWithTaxes()
    {
        $amount = new Amount(1000, 20);
        $partsWithTaxes = $amount->getPartsWithTaxes();
        $this->assertArrayHasKey('outOfTaxes', $partsWithTaxes);
        $this->assertArrayHasKey('valueAddedTax', $partsWithTaxes);
        $this->assertArrayHasKey('taxIncluded', $partsWithTaxes);
        $this->assertArrayHasKey('discount', $partsWithTaxes);
        $this->assertArrayHasKey('discountPercent', $partsWithTaxes);
        $this->assertArrayHasKey('discountedOutOfTaxes', $partsWithTaxes);
    }

    /**
     * @throws Exception
     */
    public function testGetPartsWithTaxesWithValues()
    {
        $amount = new Amount(1000, 20);
        $partsWithTaxes = $amount->getPartsWithTaxes();
        $this->assertEquals(1000, $partsWithTaxes['outOfTaxes']);
        $this->assertEquals(200, $partsWithTaxes['valueAddedTax']);
        $this->assertEquals(1200, $partsWithTaxes['taxIncluded']);
        $this->assertNull($partsWithTaxes['discount']);
        $this->assertNull($partsWithTaxes['discountPercent']);
        $this->assertEquals(1000, $partsWithTaxes['discountedOutOfTaxes']);
    }

    public function testGetPartsWithoutTaxes()
    {
        $amount = new Amount(1000);
        $partsWithTaxes = $amount->getPartsWithoutTaxes();
        $this->assertEquals(1000, $partsWithTaxes['amount']);
        $this->assertNull($partsWithTaxes['discount']);
        $this->assertNull($partsWithTaxes['discountPercent']);
        $this->assertEquals(1000, $partsWithTaxes['discountedAmount']);
    }
}
