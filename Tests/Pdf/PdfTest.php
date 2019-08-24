<?php

namespace Atournayre\ToolboxBundle\Tests\Pdf;

use Atournayre\ToolboxBundle\Service\Pdf\Generator\Html2PdfGenerator;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class PdfTest extends TestCase
{
    public function testCreate()
    {
        $html2PdfGenerator = new Html2PdfGenerator(
            'P',
            'A4',
            'fr',
            true,
            'UTF-8',
            [0, 0, 0, 0]
        );
        $this->assertInstanceOf(Html2Pdf::class, $html2PdfGenerator->create());
    }
}
