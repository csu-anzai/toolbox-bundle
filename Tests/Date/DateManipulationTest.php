<?php

namespace Atournayre\ToolboxBundle\Tests\Date;

use Atournayre\ToolboxBundle\Service\Date\DateManipulation;
use DateTime;
use PHPUnit\Framework\TestCase;

class DateManipulationTest extends TestCase
{
    public function testAdd3Days()
    {
        $date = new DateTime('2019-08-01');
        $dateService = new DateManipulation();
        $this->assertEquals(new DateTime('2019-08-04'), $dateService->addDays($date, 3));
    }

    public function testAdd1Day()
    {
        $date = new DateTime('2019-08-01');
        $dateService = new DateManipulation();
        $this->assertEquals(new DateTime('2019-08-02'), $dateService->addDays($date, 1));
    }

    public function testAdd31Days()
    {
        $date = new DateTime('2019-08-01');
        $dateService = new DateManipulation();
        $this->assertEquals(new DateTime('2019-09-01'), $dateService->addDays($date, 31));
    }

    public function testMars1stDayFor2018()
    {
        $date = new DateTime('2018-02-01');
        $dateService = new DateManipulation();
        $this->assertEquals(new DateTime('2018-03-01'), $dateService->addDays($date, 29));
    }

    public function testMars1stDayFor2019()
    {
        $date = new DateTime('2019-02-01');
        $dateService = new DateManipulation();
        $this->assertEquals(new DateTime('2019-03-01'), $dateService->addDays($date, 28));
    }

    public function testAdd2Hours()
    {
        $datetime = new DateTime('2019-08-01 01:00:00');
        $dateService = new DateManipulation();
        $this->assertEquals(new DateTime('2019-08-01 03:00:00'), $dateService->addHours($datetime, 2));
    }

    public function testAdd2HoursByParameter()
    {
        $datetime = new DateTime('2019-08-01 01:00:00');
        $dateService = new DateManipulation();
        $this->assertEquals(new DateTime('2019-08-01 03:00:00'), $dateService->add($datetime, 2, DateManipulation::ELEMENT_TYPE_HOURS));
    }
}
