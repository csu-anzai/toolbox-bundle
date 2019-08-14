<?php

namespace Atournayre\ToolboxBundle\Service\Date;

use DateTime;
use DateTimeInterface;

class Date
{
    const TYPE_ELEMENT_HEURES = 'hours';
    const TYPE_ELEMENT_JOURS = 'days';

    /**
     * @param DateTimeInterface $dateTime
     *
     * @return DateTime
     */
    public function conversionInterfaceVersDateTime(DateTimeInterface $dateTime): DateTime
    {
        return DateTime::createFromFormat(
            DateTimeInterface::ATOM,
            $dateTime->format(DateTimeInterface::ATOM)
        );
    }

    /**
     * @param DateTimeInterface $dateTime
     * @param int               $nombreDeJours
     *
     * @return DateTime
     */
    public function ajoutJours(DateTimeInterface $dateTime, int $nombreDeJours): DateTime
    {
        return $this->ajout($dateTime, $nombreDeJours, self::TYPE_ELEMENT_JOURS);
    }
    /**
     * @param DateTimeInterface $dateTime
     * @param int               $nombreDHeures
     *
     * @return DateTime
     */
    public function ajoutHeures(DateTimeInterface $dateTime, int $nombreDHeures): DateTime
    {
        return $this->ajout($dateTime, $nombreDHeures, self::TYPE_ELEMENT_HEURES);
    }

    /**
     * @param DateTimeInterface $dateTime
     * @param int               $nombre
     * @param string            $typeElement Utiliser une des constantes commençant par TYPE_ELEMENT_
     *
     * @return DateTime
     */
    public function ajout(DateTimeInterface $dateTime, int $nombre, string $typeElement): DateTime
    {
        $dateTime = $this->conversionInterfaceVersDateTime($dateTime);
        $dateTime->modify(sprintf('+ %s %s', $nombre, $typeElement));
        return $dateTime;
    }
}
