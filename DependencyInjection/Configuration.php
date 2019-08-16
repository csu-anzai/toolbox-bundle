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
                                ->scalarNode('project_directory')
                                    ->defaultValue('%kernel.project_dir%')
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
}
