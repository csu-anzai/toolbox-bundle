<?php

namespace Atournayre\ToolboxBundle\Service\Date;

use DateTime;
use DateTimeInterface;

class DateManipulation
{
    const ELEMENT_TYPE_HOURS = 'hours';
    const ELEMENT_TYPE_DAYS  = 'days';

    /**
     * @param DateTimeInterface $dateTime
     *
     * @return DateTime
     */
    public function convertDateTimeInterfaceToDateTime(DateTimeInterface $dateTime): DateTime
    {
        return DateTime::createFromFormat(
            DateTimeInterface::ATOM,
            $dateTime->format(DateTimeInterface::ATOM)
        );
    }

    /**
     * @param DateTimeInterface $dateTime
     * @param int               $numberOfDays
     *
     * @return DateTime
     */
    public function addDays(DateTimeInterface $dateTime, int $numberOfDays): DateTime
    {
        return $this->add($dateTime, $numberOfDays, self::ELEMENT_TYPE_DAYS);
    }
    /**
     * @param DateTimeInterface $dateTime
     * @param int               $numberOfHours
     *
     * @return DateTime
     */
    public function addHours(DateTimeInterface $dateTime, int $numberOfHours): DateTime
    {
        return $this->add($dateTime, $numberOfHours, self::ELEMENT_TYPE_HOURS);
    }

    /**
     * @param DateTimeInterface $dateTime
     * @param int               $number
     * @param string            $elementType
     *
     * @return DateTime
     */
    public function add(DateTimeInterface $dateTime, int $number, string $elementType): DateTime
    {
        $dateTime = $this->convertDateTimeInterfaceToDateTime($dateTime);
        $dateTime->modify(sprintf('+ %s %s', $number, $elementType));
        return $dateTime;
    }
}
