<?php

namespace Atournayre\ToolboxBundle\Service\Numbering;

class Numbering
{
    /**
     * @var int
     */
    private $padLength;

    /**
     * @var string
     */
    private $padString;

    /**
     * @var int
     */
    private $padType;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $suffix;

    /**
     * Numbering constructor.
     *
     * @param int|null    $padLength
     * @param string|null $padString
     * @param int|null    $padType
     * @param string|null $prefix
     * @param string|null $suffix
     */
    public function __construct(
        ?int $padLength = null,
        ?string $padString = null,
        ?int $padType = null,
        ?string $prefix = null,
        ?string $suffix = null
    ) {
        $this->padLength = $padLength;
        $this->padString = $padString;
        $this->padType = $padType;
        $this->prefix = $prefix;
        $this->suffix = $suffix;
    }

    /**
     * @param int|null $number
     *
     * @return int
     */
    public function increment(?int $number = null): int
    {
        return ++$number ?? 1;
    }

    /**
     * @param string $number
     * @param string $prefix
     *
     * @return string
     */
    public function prefix(string $number, string $prefix): string
    {
        return $prefix.$number;
    }

    /**
     * @param string $number
     * @param string $suffix
     *
     * @return string
     */
    public function suffix(string $number, string $suffix): string
    {
        return $number.$suffix;
    }

    /**
     * @param string $number
     *
     * @return string
     */
    public function pad(string $number): string
    {
        return str_pad($number, $this->padLength, $this->padString, $this->padType);
    }

    /**
     * @param string $number
     *
     * @return string
     */
    public function number(string $number): string
    {
        $number = $this->pad($number);
        if (null !== $this->prefix) {
            $number = $this->prefix($number, $this->prefix);
        }
        if (null !== $this->suffix) {
            $number = $this->suffix($number, $this->suffix);
        }
        return $number;
    }
}
