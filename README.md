# ToolboxBundle for Symfony 4
## Services

| Services | Description |
|---|---|
|Date|Carbon with additional methods |
|Excel|Create and manage Excel files|
|File|Create and manage files|
|Google|Connect to Google Calendar API|

## Service declaration
In `config/services.yaml`

### How to declare services
Pick only services you want to use.

    Atournayre\ToolboxBundle\Service\Date\DateService: '@atournayre_toolbox.date'
    Atournayre\ToolboxBundle\Service\Excel\Excel: '@atournayre_toolbox.excel'
    Atournayre\ToolboxBundle\Service\Google\Calendar\GoogleDateService: '@atournayre_toolbox.google.date'
    Atournayre\ToolboxBundle\Service\Google\Calendar\GoogleCalendarService: '@atournayre_toolbox.google.calendar'
    Atournayre\ToolboxBundle\Service\Google\Calendar\GoogleCalendarEventService: '@atournayre_toolbox.google.calendar.event'
    Atournayre\ToolboxBundle\Service\\Google\Calendar\GoogleClientService: '@atournayre_toolbox.google.client'

## Continuous Integration
<img src="https://travis-ci.com/atournayre/toolbox-bundle.svg?branch=master" />