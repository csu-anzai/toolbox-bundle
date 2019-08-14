<?php

namespace Atournayre\ToolboxBundle\Service\Date;

use DateTimeInterface;

class DateFormat
{
    /**
     * @var string
     */
    private $valeurVide;

    /**
     * @var string
     */
    private $formatSimple;

    /**
     * DateFormat constructor.
     *
     * @param string $valeurVide
     * @param string $formatSimple
     */
    public function __construct(string $valeurVide, string $formatSimple)
    {
        $this->valeurVide = $valeurVide;
        $this->formatSimple = $formatSimple;
    }

    /**
     * @param DateTimeInterface|null $dateTime
     *
     * @return string
     */
    public function simpleDate(?DateTimeInterface $dateTime): string
    {
        return $this->valeurVideOuFormat($dateTime, $this->formatSimple);
    }

    /**
     * @param DateTimeInterface|null $dateTime
     *
     * @return string
     */
    public function anneeSurDeuxChiffres(?DateTimeInterface $dateTime): string
    {
        return $this->valeurVideOuFormat($dateTime, 'y');
    }

    /**
     * @param DateTimeInterface|null $dateTime
     * @param string                 $format
     *
     * @return string
     */
    public function valeurVideOuFormat(?DateTimeInterface $dateTime, string $format): string
    {
        return is_null($dateTime) ? $this->valeurVide : $dateTime->format($format);
    }
}