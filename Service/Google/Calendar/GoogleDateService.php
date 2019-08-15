<?php

namespace Atournayre\ToolboxBundle\Service\Google\Calendar;

use DateTime;
use Google_Service_Calendar_EventDateTime;

class GoogleDateService
{
    const DATE_FORMAT = 'Y-m-d\TH:i:s';

    /**
     * @var string
     */
    private $timeZone;

    /**
     * GoogleCalendarService constructor.
     *
     * @param string $timeZone
     */
    public function __construct(string $timeZone)
    {
        $this->timeZone = $timeZone;
    }

    /**
     * @param DateTime $dateTime
     *
     * @return Google_Service_Calendar_EventDateTime
     */
    public function create(DateTime $dateTime): Google_Service_Calendar_EventDateTime
    {
        $eventDatetime = new Google_Service_Calendar_EventDateTime();
        $eventDatetime->setDateTime($this->formatDatetime($dateTime));
        $eventDatetime->setTimeZone($this->timeZone);
        return $eventDatetime;
    }

    /**
     * @param DateTime $dateTime
     *
     * @return string
     */
    public function formatDatetime(DateTime $dateTime): string
    {
        return $dateTime->format(self::DATE_FORMAT);
    }
}
