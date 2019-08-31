<?php


namespace Atournayre\ToolboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Atournayre\ToolboxBundle\Repository\CountryRepository")
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $alpha2;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $alpha3;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $countryCode;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $iso31662;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $subRegion;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $intermediateRegion;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $regionCode;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $subRegionCode;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $intermediateRegionCode;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlpha2()
    {
        return $this->alpha2;
    }

    /**
     * @param mixed $alpha2
     *
     * @return Country
     */
    public function setAlpha2($alpha2)
    {
        $this->alpha2 = $alpha2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlpha3()
    {
        return $this->alpha3;
    }

    /**
     * @param mixed $alpha3
     *
     * @return Country
     */
    public function setAlpha3($alpha3)
    {
        $this->alpha3 = $alpha3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     *
     * @return Country
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIso31662()
    {
        return $this->iso31662;
    }

    /**
     * @param mixed $iso31662
     *
     * @return Country
     */
    public function setIso31662($iso31662)
    {
        $this->iso31662 = $iso31662;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     *
     * @return Country
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubRegion()
    {
        return $this->subRegion;
    }

    /**
     * @param mixed $subRegion
     *
     * @return Country
     */
    public function setSubRegion($subRegion)
    {
        $this->subRegion = $subRegion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIntermediateRegion()
    {
        return $this->intermediateRegion;
    }

    /**
     * @param mixed $intermediateRegion
     *
     * @return Country
     */
    public function setIntermediateRegion($intermediateRegion)
    {
        $this->intermediateRegion = $intermediateRegion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegionCode()
    {
        return $this->regionCode;
    }

    /**
     * @param mixed $regionCode
     *
     * @return Country
     */
    public function setRegionCode($regionCode)
    {
        $this->regionCode = $regionCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubRegionCode()
    {
        return $this->subRegionCode;
    }

    /**
     * @param mixed $subRegionCode
     *
     * @return Country
     */
    public function setSubRegionCode($subRegionCode)
    {
        $this->subRegionCode = $subRegionCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIntermediateRegionCode()
    {
        return $this->intermediateRegionCode;
    }

    /**
     * @param mixed $intermediateRegionCode
     *
     * @return Country
     */
    public function setIntermediateRegionCode($intermediateRegionCode)
    {
        $this->intermediateRegionCode = $intermediateRegionCode;
        return $this;
    }
}
