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
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('atournayre_toolbox');

        $this->googleConfiguration($rootNode);
        $this->emailConfiguration($rootNode);
        $this->pdfConfiguration($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function googleConfiguration(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('google')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('timezone')
                            ->defaultValue($this->googleDefaultTimezone())
                        ->end()
                        ->arrayNode('calendar')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('allowed_role')
                                    ->defaultValue('owner')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('client')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('application_name')
                                    ->defaultValue('Application')
                                ->end()
                                ->scalarNode('configuration_directory')
                                    ->defaultValue('/config/google')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @return string
     */
    private function googleDefaultTimezone(): string
    {
        return !empty(ini_get('date.timezone'))
            ? ini_get('date.timezone')
            : 'Europe/Paris';
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function emailConfiguration(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
                ->arrayNode('email')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('noreply')
                            ->defaultValue('noreply@example.com')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function pdfConfiguration(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
                ->arrayNode('pdf')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('orientation')
                            ->defaultValue('P')
                        ->end()
                        ->scalarNode('format')
                            ->defaultValue('A4')
                        ->end()
                        ->scalarNode('language')
                            ->defaultValue('fr')
                        ->end()
                        ->scalarNode('unicode')
                            ->defaultTrue()
                        ->end()
                        ->scalarNode('encoding')
                            ->defaultValue('UTF-8')
                        ->end()
                        ->arrayNode('margins')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode(0)->defaultValue(0)->end()
                                ->scalarNode(1)->defaultValue(0)->end()
                                ->scalarNode(2)->defaultValue(0)->end()
                                ->scalarNode(3)->defaultValue(0)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
