<?php

namespace Atournayre\ToolboxBundle\Service\Token;

use DateTime;
use Exception;

class Token
{
    /**
     * @return string
     * @throws Exception
     */
    public function generate(): string
    {
        return (new DateTime())->format('YmdHisu');
    }
}
