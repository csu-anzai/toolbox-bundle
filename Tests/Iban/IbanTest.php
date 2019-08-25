<?php

namespace Atournayre\ToolboxBundle\Tests\Iban;

use IBAN;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class IbanTest extends TestCase
{
    const IBAN_VALID = 'FR7630001007941234567890185';
    const IBAN_INVALID = 'FR76XXXXX007941234567890185';

    public function testCountry()
    {
        $this->assertEquals('FR', (new IBAN(self::IBAN_VALID))->Country());
    }

    public function testChecksum()
    {
        $this->assertEquals('76', (new IBAN(self::IBAN_VALID))->Checksum());
    }

    public function testBank()
    {
        $this->assertEquals('30001', (new IBAN(self::IBAN_VALID))->Bank());
    }

    public function testBranch()
    {
        $this->assertEquals('00794', (new IBAN(self::IBAN_VALID))->Branch());
    }

    public function testAccount()
    {
        $this->assertEquals('1234567890185', (new IBAN(self::IBAN_VALID))->Account());
    }

    public function testNationalChecksum()
    {
        $this->assertEquals('85', (new IBAN(self::IBAN_VALID))->NationalChecksum());
    }

    public function testVerify()
    {
        $this->assertTrue((new IBAN(self::IBAN_VALID))->Verify());
    }

    public function testVerifyFalse()
    {
        $this->assertFalse((new IBAN())->Verify(self::IBAN_VALID . 'R'));
    }

    public function testInvalid()
    {
        $this->assertFalse((new IBAN())->Verify(self::IBAN_INVALID));
    }
}
