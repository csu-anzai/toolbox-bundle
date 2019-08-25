<?php

namespace Atournayre\ToolboxBundle\Service\Insee;

class Insee
{
    /**
     * @param $result
     *
     * @return mixed
     */
    public function decode($result)
    {
        return json_decode($result->getBody());
    }
}
