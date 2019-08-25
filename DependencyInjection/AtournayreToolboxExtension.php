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
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
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
            $this->prefix('date'),
            new Definition(DateService::class)
        );
    }

    /**
     * @param ContainerBuilder $container
     */
    public function excelServices(ContainerBuilder $container): void
    {
        $container->setDefinition(
            $this->prefix('excel'),
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
    private function prefix(string $suffix): string
    {
        return $this->getAlias() . '.' . $suffix;
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function definitionGoogleDate(ContainerBuilder $container, array $config): void
    {
        $container->setDefinition(
            $this->prefix('google.date'),
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
            $this->prefix('google.calendar.event'),
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
            $this->prefix('google.calendar'),
            new Definition(
                GoogleCalendarService::class,
                [
                    new Definition(GoogleClientService::class),
                    $config['calendar']['allowed_role'],
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
        $this->setGoogleParameters($container, $config);
        $this->setEmailParameters($container, $config);
        $this->setPdfParameters($container, $config);
        $this->setNumberingParameters($container, $config);
        $this->setMaintenanceParameters($container, $config);
        $this->setEnvironmentParameters($container, $config);
        $this->setCrudControllerParameters($container, $config);
        $this->setEncryptParameters($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    public function setEmailParameters(ContainerBuilder $container, array $config): void
    {
        $container->setParameter($this->prefix('email.noreply'), $config['email']['noreply']);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    public function setGoogleParameters(ContainerBuilder $container, array $config): void
    {
        $currentConfig = $config['google'];
        $container->setParameter($this->prefix('google.timezone'), $currentConfig['timezone']);
        $container->setParameter(
            $this->prefix('google.calendar.allowed_role'),
            $currentConfig['calendar']['allowed_role']
        );
        $configGoogleClient = $currentConfig['client'];
        $container->setParameter(
            $this->prefix('google.client.application_name'),
            $configGoogleClient['application_name']
        );
        $container->setParameter(
            $this->prefix('google.client.configuration_directory'),
            $configGoogleClient['configuration_directory']
        );
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setPdfParameters(ContainerBuilder $container, array $config): void
    {
        $currentConfig = $config['pdf'];
        $container->setParameter($this->prefix('pdf.orientation'), $currentConfig['orientation']);
        $container->setParameter($this->prefix('pdf.format'), $currentConfig['format']);
        $container->setParameter($this->prefix('pdf.language'), $currentConfig['language']);
        $container->setParameter($this->prefix('pdf.unicode'), $currentConfig['unicode']);
        $container->setParameter($this->prefix('pdf.encoding'), $currentConfig['encoding']);
        $container->setParameter($this->prefix('pdf.margins'), $currentConfig['margins']);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setNumberingParameters(ContainerBuilder $container, array $config): void
    {
        $currentConfig = $config['numbering'];
        $container->setParameter($this->prefix('numbering.pad_length'), $currentConfig['pad_length']);
        $container->setParameter($this->prefix('numbering.pad_string'), $currentConfig['pad_string']);
        $container->setParameter($this->prefix('numbering.pad_type'), $currentConfig['pad_type']);
        $container->setParameter($this->prefix('numbering.prefix'), $currentConfig['prefix']);
        $container->setParameter($this->prefix('numbering.suffix'), $currentConfig['suffix']);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setMaintenanceParameters(ContainerBuilder $container, array $config): void
    {
        $currentConfig = $config['maintenance'];
        $container->setParameter($this->prefix('maintenance'), $currentConfig);
        $container->setParameter($this->prefix('maintenance.system.base'), $currentConfig['system']['base']);
        $container->setParameter($this->prefix('maintenance.system.title'), $currentConfig['system']['title']);
        $container->setParameter($this->prefix('maintenance.system.content'), $currentConfig['system']['content']);
        $container->setParameter($this->prefix('maintenance.custom.template'),$currentConfig['custom']['template']);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setEnvironmentParameters(ContainerBuilder $container, array $config): void
    {
        $container->setParameter($this->prefix('environment_commands'), $config['environment_commands']);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setCrudControllerParameters(ContainerBuilder $container, array $config): void
    {
        $currentConfig = $config['crud_controller'];
        $container->setParameter($this->prefix('crud_controller.create'), $currentConfig['create']);
        $container->setParameter($this->prefix('crud_controller.read'), $currentConfig['read']);
        $container->setParameter($this->prefix('crud_controller.update'), $currentConfig['update']);
        $container->setParameter($this->prefix('crud_controller.delete'), $currentConfig['delete']);
        $container->setParameter(
            $this->prefix('crud_controller.delete.form_template'),
            $currentConfig['delete']['form_template']
        );
        $container->setParameter(
            $this->prefix('crud_controller.delete.form_button_label'),
            $currentConfig['delete']['form_button_label']
        );
        $container->setParameter(
            $this->prefix('crud_controller.delete.default_success_message'),
            $currentConfig['delete']['default_success_message']
        );
        $container->setParameter(
            $this->prefix('crud_controller.delete.default_confirmation_message'),
            $currentConfig['delete']['default_confirmation_message']
        );
        $container->setParameter(
            $this->prefix('crud_controller.delete.default_confirmation_message'),
            $currentConfig['delete']['default_confirmation_message']
        );
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setEncryptParameters(ContainerBuilder $container, array $config): void
    {
        $container->setParameter($this->prefix('encrypt.key'), $config['encrypt']['key']);
        $container->setParameter($this->prefix('encrypt.disabled'), $config['encrypt']['disabled']);
    }
}
