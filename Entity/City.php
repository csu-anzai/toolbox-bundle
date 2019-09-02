<?php

namespace Atournayre\ToolboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Atournayre\ToolboxBundle\Repository\CityRepository")
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $inseeCode;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $delivery_name;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $line5;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $longitude;

    /**
     * @ORM\ManyToOne(targetEntity="Atournayre\ToolboxBundle\Entity\Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $country;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getInseeCode()
    {
        return $this->inseeCode;
    }

    /**
     * @param mixed $inseeCode
     *
     * @return City
     */
    public function setInseeCode($inseeCode)
    {
        $this->inseeCode = $inseeCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     *
     * @return City
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeliveryName()
    {
        return $this->delivery_name;
    }

    /**
     * @param mixed $delivery_name
     *
     * @return City
     */
    public function setDeliveryName($delivery_name)
    {
        $this->delivery_name = $delivery_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLine5()
    {
        return $this->line5;
    }

    /**
     * @param mixed $line5
     *
     * @return City
     */
    public function setLine5($line5)
    {
        $this->line5 = $line5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     *
     * @return City
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     *
     * @return City
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     *
     * @return City
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }
}
