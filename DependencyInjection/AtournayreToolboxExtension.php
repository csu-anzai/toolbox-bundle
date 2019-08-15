<?php

namespace Atournayre\ToolboxBundle\DependencyInjection;

use Atournayre\ToolboxBundle\Service\Date\DateService;
use Atournayre\ToolboxBundle\Service\Excel\Excel;
use Atournayre\ToolboxBundle\Service\Google\Calendar\GoogleCalendarEventService;
use Atournayre\ToolboxBundle\Service\Google\Calendar\GoogleCalendarService;
use Atournayre\ToolboxBundle\Service\Google\Calendar\GoogleClientService;
use Atournayre\ToolboxBundle\Service\Google\Calendar\GoogleDateService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Filesystem\Filesystem;
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

        $this->dateServices($container);
        $this->excelServices($container);
        $this->googleServices($container, $config['google']);
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
     */
    public function dateServices(ContainerBuilder $container): void
    {
        $container->setDefinition(
            $this->setDefinitionId('date'),
            new Definition(DateService::class)
        );
    }

    /**
     * @param ContainerBuilder $container
     */
    public function excelServices(ContainerBuilder $container): void
    {
        $container->setDefinition(
            $this->setDefinitionId('excel'),
            new Definition(Excel::class)
        );
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    public function googleServices(ContainerBuilder $container, array $config): void
    {
        $container->setDefinition(
            $this->setDefinitionId('google.date'),
            new Definition(
                GoogleDateService::class,
                [$config['timezone']]
            )
        );
        $container->setDefinition(
            $this->setDefinitionId('google.calendar.event'),
            new Definition(GoogleCalendarEventService::class)
        );
        $container->setDefinition(
            $this->setDefinitionId('google.calendar'),
            new Definition(
                GoogleCalendarService::class,
                [
                    GoogleClientService::class,
                    $config['calendar']['allowed_role']
                ]
            )
        );
        $container->setDefinition(
            $this->setDefinitionId('google.client'),
            new Definition(
                GoogleClientService::class,
                [
                    $config['client']['application_name'],
                    $config['client']['configuration_directory'],
                    $config['client']['project_directory'],
                    Filesystem::class
                ]
            )
        );
    }

    /**
     * @param string $suffix
     *
     * @return string
     */
    private function setDefinitionId(string $suffix): string
    {
        return $this->getAlias().'.'.$suffix;
    }
}
