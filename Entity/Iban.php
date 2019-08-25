<?php

namespace Atournayre\ToolboxBundle\Entity;

use Atournayre\ToolboxBundle\Annotations\Encrypted;
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
     * @Encrypted
     * @ORM\Column(type="string", length=34)
     */
    private $iban;

    /**
     * @Encrypted
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
     *
     * @return Iban
     */
    public function setIban($iban)
    {
        $this->iban = $iban;
        return $this;
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
     *
     * @return Iban
     */
    public function setSwift($swift)
    {
        $this->swift = $swift;
        return $this;
    }
}
