<?php

namespace Atournayre\ToolboxBundle\Tests\Tools;

use Atournayre\ToolboxBundle\Service\Tools\ArrayService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ArrayServiceTest extends TestCase
{
    public function testFilterBooleans()
    {
        $arrayActual = [
            true,
            false,
            'string',
        ];
        $arrayExpected = [
            true,
        ];

        $arrayService = new ArrayService();
        $this->assertEquals($arrayExpected, $arrayService->filterBoolIsTrue($arrayActual));
    }
}
