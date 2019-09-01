<?php

namespace Atournayre\ToolboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Atournayre\ToolboxBundle\Repository\AddressRepository")
 */
class Address
{
    const TYPE_INDIVIDUAL = 'individual';
    const TYPE_PROFESSIONAL = 'professional';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=38, nullable=true)
     */
    private $customType;

    /**
     * @ORM\Column(type="string", length=38, nullable=true)
     */
    private $line1;

    /**
     * @ORM\Column(type="string", length=38, nullable=true)
     */
    private $line2;

    /**
     * @ORM\Column(type="string", length=38, nullable=true)
     */
    private $line3;

    /**
     * @ORM\Column(type="string", length=38, nullable=true)
     */
    private $line4;

    /**
     * @ORM\Column(type="string", length=38, nullable=true)
     */
    private $line5;

    /**
     * @ORM\ManyToOne(targetEntity="Atournayre\ToolboxBundle\Entity\City")
     */
    private $city;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType($type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getCustomType(): ?string
    {
        return $this->customType;
    }

    public function setCustomType($customType): self
    {
        $this->customType = $customType;
        return $this;
    }

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(?string $line1): self
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getLine2(): ?string
    {
        return $this->line2;
    }

    public function setLine2(?string $line2): self
    {
        $this->line2 = $line2;

        return $this;
    }

    public function getLine3(): ?string
    {
        return $this->line3;
    }

    public function setLine3(?string $line3): self
    {
        $this->line3 = $line3;

        return $this;
    }

    public function getLine4(): ?string
    {
        return $this->line4;
    }

    public function setLine4(?string $line4): self
    {
        $this->line4 = $line4;

        return $this;
    }

    public function getLine5(): ?string
    {
        return $this->line5;
    }

    public function setLine5(?string $line5): self
    {
        $this->line5 = $line5;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
}
