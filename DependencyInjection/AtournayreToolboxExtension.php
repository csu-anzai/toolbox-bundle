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

        $this->setParameters($container, $config);
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
            $this->prefixAtournayreToolbox('date'),
            new Definition(DateService::class)
        );
    }

    /**
     * @param ContainerBuilder $container
     */
    public function excelServices(ContainerBuilder $container): void
    {
        $container->setDefinition(
            $this->prefixAtournayreToolbox('excel'),
            new Definition(Excel::class)
        );
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    public function googleServices(ContainerBuilder $container, array $config): void
    {
        $this->definitionGoogleDate($container, $config);
        $this->definitionGoogleCalendarEvent($container);
        $this->definitionGoogleCalendar($container, $config);
    }

    /**
     * @param string $suffix
     *
     * @return string
     */
    private function prefixAtournayreToolbox(string $suffix): string
    {
        return $this->getAlias().'.'.$suffix;
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function definitionGoogleDate(ContainerBuilder $container, array $config): void
    {
        $container->setDefinition(
            $this->prefixAtournayreToolbox('google.date'),
            new Definition(
                GoogleDateService::class,
                [$config['timezone']]
            )
        );
    }

    /**
     * @param ContainerBuilder $container
     */
    private function definitionGoogleCalendarEvent(ContainerBuilder $container): void
    {
        $container->setDefinition(
            $this->prefixAtournayreToolbox('google.calendar.event'),
            new Definition(GoogleCalendarEventService::class)
        );
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function definitionGoogleCalendar(ContainerBuilder $container, array $config): void
    {
        $container->setDefinition(
            $this->prefixAtournayreToolbox('google.calendar'),
            new Definition(
                GoogleCalendarService::class,
                [
                    new Definition(GoogleClientService::class),
                    $config['calendar']['allowed_role']
                ]
            )
        );
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setParameters(ContainerBuilder $container, array $config): void
    {
        $configGoogle = $config['google'];
        $container->setParameter(
            $this->prefixAtournayreToolbox('google.timezone'),
            $configGoogle['timezone']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('google.calendar.allowed_role'),
            $configGoogle['calendar']['allowed_role']
        );
        $configGoogleClient = $configGoogle['client'];
        $container->setParameter(
            $this->prefixAtournayreToolbox('google.client.application_name'),
            $configGoogleClient['application_name']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('google.client.configuration_directory'),
            $configGoogleClient['configuration_directory']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('email.noreply'),
            $config['email']['noreply']
        );
    }
}
