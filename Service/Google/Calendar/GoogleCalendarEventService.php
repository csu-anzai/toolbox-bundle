<?php

namespace Atournayre\ToolboxBundle\Service\Google\Calendar;

use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;

class GoogleCalendarEventService
{
    /**
     * @param string                                $internalId
     * @param string                                $summary
     * @param string                                $location
     * @param string                                $description
     * @param Google_Service_Calendar_EventDateTime $startDate
     * @param Google_Service_Calendar_EventDateTime $endDate
     *
     * @return Google_Service_Calendar_Event
     */
    public function create(
        string $internalId,
        string $summary,
        string $location,
        string $description,
        Google_Service_Calendar_EventDateTime $startDate,
        Google_Service_Calendar_EventDateTime $endDate
    ): Google_Service_Calendar_Event {
        $event = new Google_Service_Calendar_Event();
        $event->setSummary($summary);
        $event->setLocation($location);
        $event->setDescription($description);
        $event->setStart($startDate);
        $event->setEnd($endDate);
        $event->setId($internalId);

        return $event;
    }
}
