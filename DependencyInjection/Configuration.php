<?php

namespace Atournayre\ToolboxBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    const DATE_EMPTY_VALUE   = '-';
    const DATE_SIMPLE_FORMAT = 'Y-m-d';

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('atournayre_toolbox');

        $this->dateConfiguration($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function dateConfiguration(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('date')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('empty_value')
                            ->defaultValue(self::DATE_EMPTY_VALUE)
                        ->end()
                        ->scalarNode('simple_format')
                            ->defaultValue(self::DATE_SIMPLE_FORMAT)
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
