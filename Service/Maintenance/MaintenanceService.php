<?php

namespace Atournayre\ToolboxBundle\Service\Maintenance;

use Atournayre\ToolboxBundle\Entity\Parameter;

class MaintenanceService
{
    const MESSAGE_MAINTENANCE_ACTIVATED    = 'Application is under maintenance.';
    const MESSAGE_MAINTENANCE_DESACTIVATED = 'Application is live.';

    /**
     * @param bool $value
     *
     * @return string
     */
    public function systemState(bool $value): string
    {
        return $value
            ? self::MESSAGE_MAINTENANCE_ACTIVATED
            : self::MESSAGE_MAINTENANCE_DESACTIVATED;
    }

    /**
     * @return Parameter
     */
    public function create(): Parameter
    {
        return (new Parameter())
            ->setCode(Parameter::CODE_MAINTENANCE)
            ->setValue(0);
    }

    /**
     * @param Parameter $parameter
     *
     * @return Parameter
     */
    public function update(Parameter $parameter): Parameter
    {
        $parameter->setValue(!$parameter->getBooleanValue());
        return $parameter;
    }
}
