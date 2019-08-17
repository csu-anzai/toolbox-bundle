<?php

namespace Atournayre\ToolboxBundle\Tests\Pdf;

use Atournayre\ToolboxBundle\Service\Pdf\Html2PdfGenerator;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class PdfTest extends TestCase
{
    public function testCreate()
    {
        $html2PdfGenerator = new Html2PdfGenerator();
        $this->assertInstanceOf(Html2Pdf::class, $html2PdfGenerator->create());
    }
}
