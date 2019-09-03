<?php

namespace Atournayre\ToolboxBundle\Service\Address;

use Atournayre\ToolboxBundle\DTO\Address\AddressDTO;

class AddressFormatter
{
    /**
     * @var AddressTransformer
     */
    private $addressTransformer;


    // For print

    // As Array

    // Inline with separator

    /**
     * AddressFormatter constructor.
     *
     * @param AddressTransformer $addressTransformer
     */
    public function __construct(AddressTransformer $addressTransformer)
    {
        $this->addressTransformer = $addressTransformer;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function line1(string $string): string
    {
        return $this->line($string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function line2(string $string): string
    {
        return $this->line($string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function line3(string $string): string
    {
        return $this->line($string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function line4(string $string): string
    {
        return $this->line($this->addressTransformer->cleanup($string));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function line5(string $string): string
    {
        return $this->line($string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function line6(string $string): string
    {
        return $this->line($string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function line(string $string): string
    {
        return strtoupper($this->convertAccents($string));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function convertAccents(string $string): string
    {
        $patterns[0] = '/[áâàåä]/ui';
        $patterns[1] = '/[ðéêèë]/ui';
        $patterns[2] = '/[íîìï]/ui';
        $patterns[3] = '/[óôòøõö]/ui';
        $patterns[4] = '/[úûùü]/ui';
        $patterns[5] = '/æ/ui';
        $patterns[6] = '/ç/ui';
        $patterns[7] = '/ß/ui';
        $replacements[0] = 'a';
        $replacements[1] = 'e';
        $replacements[2] = 'i';
        $replacements[3] = 'o';
        $replacements[4] = 'u';
        $replacements[5] = 'ae';
        $replacements[6] = 'c';
        $replacements[7] = 'ss';
        return preg_replace($patterns, $replacements, $string);
    }

    /**
     * @param AddressDTO $addressDTO
     *
     * @return array
     */
    public function get(AddressDTO $addressDTO): array
    {
        $address = [];

        if (null !== $addressDTO->line1) {
            array_push($address, $this->line1($addressDTO->line1));
        }

        if (null !== $addressDTO->line2) {
            array_push($address, $this->line2($addressDTO->line2));
        }

        if (null !== $addressDTO->line3) {
            array_push($address, $this->line3($addressDTO->line3));
        }

        if (null !== $addressDTO->line4) {
            array_push($address, $this->line4($addressDTO->line4));
        }

        if (null !== $addressDTO->line5) {
            array_push($address, $this->line5($addressDTO->line5));
        }

        if (null !== $addressDTO->line6) {
            array_push($address, $this->line6($addressDTO->line6));
        }

        return $address;
    }
}
