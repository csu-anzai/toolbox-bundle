<?php

namespace Atournayre\ToolboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Atournayre\ToolboxBundle\Repository\IbanRepository")
 */
class Iban
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=34)
     */
    private $iban;

    /**
     * @ORM\Column(type="string", length=11)
     */
    private $swift;

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
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param mixed $iban
     */
    public function setIban($iban): void
    {
        $this->iban = $iban;
    }

    /**
     * @return mixed
     */
    public function getSwift()
    {
        return $this->swift;
    }

    /**
     * @param mixed $swift
     */
    public function setSwift($swift): void
    {
        $this->swift = $swift;
    }
}
