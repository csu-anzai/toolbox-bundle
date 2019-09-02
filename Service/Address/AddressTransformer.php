<?php

namespace Atournayre\ToolboxBundle\Service\Address;

class AddressTransformer
{
    const PATTERN_BIS_AND_CO = '/(\d*\s)((bis|ter|quater)\s)(.*)/i';
    const PATTERN_MULTIPLE_NUMBER = '/(\d*)(\s*\/\s*|(\s*à\s*))(\d*)(.*)/';

    /**
     * @var array
     */
    public static $bisAndCo = [
        'bis',
        'quater',
        'ter',
    ];

    /**
     * @param string $string
     *
     * @return string
     */
    public function convertBisAndCo(string $string): string
    {
        preg_match(self::PATTERN_BIS_AND_CO, $string, $matches);

        return 0 === count($matches)
            ? $string
            : sprintf(
                '%s %s %s',
                trim($matches[1]),
                trim($this->replaceBisAndCoPattern($matches[2])),
                trim($matches[4])
            );
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function replaceBisAndCoPattern(string $string): string
    {
        return str_replace(self::$bisAndCo, substr($string, 0, 1), $string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function convertMultipleNumbers(string $string): string
    {
        preg_match(self::PATTERN_MULTIPLE_NUMBER, $string, $matches);
        return 0 === count($matches)
            ? $string
            : sprintf('%s %s', trim($matches[1]), trim($matches[5]));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function cleanPunctuation(string $string): string
    {
        $string = str_replace('\'', ' ', $string);
        return str_replace(['[', '.', ',', '\\', '/', '#', '\'', '!', '$', '%', '^', '&', '*', ';', ':', '{', '}', '=', '-', ',', '_', '`', '~', '(', ')', ']'], '', $string);
    }
}
