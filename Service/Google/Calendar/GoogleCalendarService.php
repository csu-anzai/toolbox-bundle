<?php

namespace App\Service\Google;

use Google_Exception;
use Google_Service_Calendar;
use Google_Service_Calendar_CalendarListEntry;
use Google_Service_Calendar_Event;

class GoogleCalendarService
{
    /**
     * @var Google_Service_Calendar
     */
    private $googleCalendarService;

    /**
     * @var string
     */
    private $allowedRole;

    /**
     * GoogleCalendarService constructor.
     *
     * @param GoogleClientService $googleClientService
     * @param string              $allowedRole
     *
     * @throws Google_Exception
     */
    public function __construct(GoogleClientService $googleClientService, string $allowedRole)
    {
        $this->googleCalendarService = new Google_Service_Calendar($googleClientService->getGoogleClient());
        $this->allowedRole = $allowedRole;
    }

    /**
     * @param string                        $calendarId
     * @param Google_Service_Calendar_Event $event
     *
     * @return Google_Service_Calendar_Event
     */
    public function insert(string $calendarId, Google_Service_Calendar_Event $event): Google_Service_Calendar_Event
    {
        return $this->googleCalendarService->events->insert($calendarId, $event);
    }

    /**
     * @param string                        $calendarId
     * @param string                        $eventId
     * @param Google_Service_Calendar_Event $event
     *
     * @return Google_Service_Calendar_Event
     */
    public function update(
        string $calendarId,
        string $eventId,
        Google_Service_Calendar_Event $event
    ): Google_Service_Calendar_Event {
        return $this->googleCalendarService->events->update($calendarId, $eventId, $event);
    }

    /**
     * @param string $calendarId
     * @param string $eventId
     */
    public function delete(string $calendarId, string $eventId): void
    {
        $this->googleCalendarService->events->delete($calendarId, $eventId);
    }

    /**
     * @return array
     */
    public function listEditablesCalendars(): array
    {
        $calendarList = $this->googleCalendarService->calendarList
            ->listCalendarList(['minAccessRole' => $this->allowedRole]);
        $calendars = [];
        /** @var Google_Service_Calendar_CalendarListEntry $calendar */
        foreach ($calendarList->getItems() as $calendar) {
            $calendars[$calendar->getSummary()] = $calendar->getId();
        }
        ksort($calendars);
        return $calendars;
    }
}
