<?php

namespace Atournayre\ToolboxBundle\DependencyInjection;

use Atournayre\ToolboxBundle\Service\Date\DateFormat;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class AtournayreToolboxExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $this->dateServices($container, $config['date']);
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'atournayre_toolbox';
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    public function dateServices(ContainerBuilder $container, array $config): void
    {
        $container->setDefinition(
            'atournayre_toolbox.date.format',
            new Definition(
                DateFormat::class,
                [
                    $config['empty_value'],
                    $config['simple_format'],
                ]
            )
        );
    }
}
