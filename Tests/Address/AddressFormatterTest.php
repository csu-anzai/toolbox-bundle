<?php

namespace Atournayre\ToolboxBundle\Tests\Address;

use Atournayre\ToolboxBundle\DTO\Address\AddressDTO;
use Atournayre\ToolboxBundle\Service\Address\AddressFormatter;
use Atournayre\ToolboxBundle\Service\Address\AddressTransformer;
use PHPUnit\Framework\TestCase;

class AddressFormatterTest extends TestCase
{
    public function testFormatLine1()
    {
        $addressFormatter = new AddressFormatter(new AddressTransformer());
        $this->assertEquals('MONSIEUR PIERRE DURAND', $addressFormatter->line1('Monsieur Pierre DURAND'));
    }

    public function testFormatLine4()
    {
        $addressFormatter = new AddressFormatter(new AddressTransformer());
        $this->assertEquals('25 B RUE DES IDEES', $addressFormatter->line4('25 bis, rue des Idées'));
    }

    public function testFormatLine6()
    {
        $addressFormatter = new AddressFormatter(new AddressTransformer());
        $this->assertEquals('33500 LIBOURNE', $addressFormatter->line6('33500 Libourne'));
    }

    public function testFormatLine2()
    {
        $addressFormatter = new AddressFormatter(new AddressTransformer());
        $this->assertEquals('CHEZ MIREILLE COUPEAU APPARTEMENT 2', $addressFormatter->line2('Chez Mireille Coupeau Appartement 2'));
    }

    public function testFormatLine3()
    {
        $addressFormatter = new AddressFormatter(new AddressTransformer());
        $this->assertEquals('ENTREE 2 BATIMENT B', $addressFormatter->line3('Entrée 2 bâtiment B'));
    }

    public function testFullAddress1()
    {
        $addressDTO = new AddressDTO();
        $addressDTO->line1 = 'Monsieur Pierre DURAND';
        $addressDTO->line2 = null;
        $addressDTO->line4 = '25 bis, rue des Idées';
        $addressDTO->line6 = '33500 Libourne';

        $addressFormatter = new AddressFormatter(new AddressTransformer());
        $formattedAddress = $addressFormatter->get($addressDTO);
        $this->assertArrayHasKey('line1', $formattedAddress);
        $this->assertArrayNotHasKey('line2', $formattedAddress);
        $this->assertArrayHasKey('line4', $formattedAddress);
        $this->assertArrayHasKey('line6', $formattedAddress);

        $this->assertEquals('MONSIEUR PIERRE DURAND', $formattedAddress['line1']);
        $this->assertEquals('25 B RUE DES IDEES', $formattedAddress['line4']);
        $this->assertEquals('33500 LIBOURNE', $formattedAddress['line6']);
    }
}
