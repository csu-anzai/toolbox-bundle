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
        return $this->getAlias() . '.' . $suffix;
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
        $this->setPdfParameters($container, $config);
        $this->setNumberingParameters($container, $config);
        $this->setMaintenanceParameters($container, $config);
        $this->setEnvironmentParameters($container, $config);
        $this->setCrudControllerParameters($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setPdfParameters(ContainerBuilder $container, array $config): void
    {
        $configPdf = $config['pdf'];
        $container->setParameter($this->prefixAtournayreToolbox('pdf.orientation'), $configPdf['orientation']);
        $container->setParameter($this->prefixAtournayreToolbox('pdf.format'), $configPdf['format']);
        $container->setParameter($this->prefixAtournayreToolbox('pdf.language'), $configPdf['language']);
        $container->setParameter($this->prefixAtournayreToolbox('pdf.unicode'), $configPdf['unicode']);
        $container->setParameter($this->prefixAtournayreToolbox('pdf.encoding'), $configPdf['encoding']);
        $container->setParameter($this->prefixAtournayreToolbox('pdf.margins'), $configPdf['margins']);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setNumberingParameters(ContainerBuilder $container, array $config): void
    {
        $configNumbering = $config['numbering'];
        $container->setParameter(
            $this->prefixAtournayreToolbox('numbering.pad_length'),
            $configNumbering['pad_length']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('numbering.pad_string'),
            $configNumbering['pad_string']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('numbering.pad_type'),
            $configNumbering['pad_type']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('numbering.prefix'),
            $configNumbering['prefix']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('numbering.suffix'),
            $configNumbering['suffix']
        );
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setMaintenanceParameters(ContainerBuilder $container, array $config): void
    {
        $configMaintenance = $config['maintenance'];
        $container->setParameter(
            $this->prefixAtournayreToolbox('maintenance'),
            $configMaintenance
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('maintenance.system.base'),
            $configMaintenance['system']['base']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('maintenance.system.title'),
            $configMaintenance['system']['title']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('maintenance.system.content'),
            $configMaintenance['system']['content']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('maintenance.custom.template'),
            $configMaintenance['custom']['template']
        );
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setEnvironmentParameters(ContainerBuilder $container, array $config): void
    {
        $container->setParameter(
            $this->prefixAtournayreToolbox('environment_commands'),
            $config['environment_commands']
        );
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setCrudControllerParameters(ContainerBuilder $container, array $config): void
    {
        $configCrudController = $config['crud_controller'];
        $container->setParameter(
            $this->prefixAtournayreToolbox('crud_controller.create'),
            $configCrudController['create']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('crud_controller.read'),
            $configCrudController['read']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('crud_controller.update'),
            $configCrudController['update']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('crud_controller.delete'),
            $configCrudController['delete']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('crud_controller.delete.form_template'),
            $configCrudController['delete']['form_template']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('crud_controller.delete.form_button_label'),
            $configCrudController['delete']['form_button_label']
        );
        $container->setParameter(
            $this->prefixAtournayreToolbox('crud_controller.delete.default_confirmation_message'),
            $configCrudController['delete']['default_confirmation_message']
        );
    }
}
