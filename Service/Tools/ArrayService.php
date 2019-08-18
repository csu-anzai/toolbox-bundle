<?php

namespace Atournayre\ToolboxBundle\Service\Tools;

class ArrayService
{
    /**
     * @param array $array
     *
     * @return array
     */
    public function filterBoolIsTrue(array $array): array
    {
        return array_filter(
            $array,
            function ($value)
            {
                return is_bool($value) ? $value : null;
            },
            ARRAY_FILTER_USE_BOTH
        );
    }

    /**
     * @param array  $collection
     * @param string $keyName
     * @param string $valueName
     *
     * @return array
     */
    public function arrayMapKeyValue(array $collection, string $keyName, string $valueName): array
    {
        $array = [];
        foreach ($collection as $item) {
            $array[$item[$keyName]] = $item[$valueName];
        }

        return $array;
    }

    /**
     * @param array    $collection
     * @param callable $callback
     *
     * @return array
     */
    public function arrayMap(array $collection, callable $callback): array
    {
        return array_map(
            function ($callbackParameter) use ($callback)
            {
                return $this->$callback($callbackParameter);
            },
            $collection
        );
    }
}
