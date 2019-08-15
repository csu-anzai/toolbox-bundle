<?php

namespace Atournayre\ToolboxBundle\Service\Date;

use Carbon\Carbon;
use DateTimeInterface;

class DateService extends Carbon
{
    /**
     * @param DateTimeInterface $dateTime
     *
     * @return DateService|Carbon
     */
    public function createFromDateTime(DateTimeInterface $dateTime) {
        return self::createFromDate(
            $dateTime->format('Y'),
            $dateTime->format('m'),
            $dateTime->format('d')
        );
    }
}
