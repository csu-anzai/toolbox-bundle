<?php

namespace Atournayre\ToolboxBundle;

use Atournayre\ToolboxBundle\DependencyInjection\AtournayreToolboxExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AtournayreToolboxBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new AtournayreToolboxExtension();
        }

        return $this->extension;
    }
}
