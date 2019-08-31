<?php

namespace Atournayre\ToolboxBundle\Twig;

use Atournayre\ToolboxBundle\Service\Token\Token;
use Exception;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig_Filter;
use Twig_Function;

class TokenExtension extends AbstractExtension implements ExtensionInterface
{
    const FILTER_CHARACTER_BEFORE = '&';
    const FUNCTION_CHARACTER_BEFORE = '?';

    /**
     * @var Token
     */
    private $token;

    /**
     * TokenExtension constructor.
     *
     * @param Token $token
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new Twig_Filter('token', [
                $this,
                'tokenFilter',
            ]),
        ];
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new Twig_Function('token', [
                $this,
                'tokenFunction',
            ]),
            new Twig_Function('generateToken', [
                $this,
                'generateToken',
            ]),
        ];
    }

    /**
     * @param string $string
     * @param string $characterBefore
     *
     * @return string
     * @throws Exception
     */
    public function tokenFilter(string $string, string $characterBefore = self::FILTER_CHARACTER_BEFORE): string
    {
        $this->throwEmptyCharacterBeforeException($characterBefore);
        return $this->addTokenToString($string, $characterBefore);
    }

    /**
     * @param string $string
     * @param string $characterBefore
     *
     * @return string
     * @throws Exception
     */
    public function tokenFunction(string $string, string $characterBefore = self::FUNCTION_CHARACTER_BEFORE): string
    {
        $this->throwEmptyCharacterBeforeException($characterBefore);
        return $this->addTokenToString($string, $characterBefore);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function generateToken(): string
    {
        return $this->token->generate();
    }

    /**
     * @param string $string
     * @param string $characterBefore
     *
     * @return string
     * @throws Exception
     */
    private function addTokenToString(string $string, string $characterBefore): string
    {
        return $string . $characterBefore . $this->generateToken();
    }

    /**
     * @param string $characterBefore
     *
     * @throws Exception
     */
    private function throwEmptyCharacterBeforeException(string $characterBefore): void
    {
        if ('' === $characterBefore) {
            throw new Exception(
                __METHOD__ . ' must have a character before. Use generateToken() if you want only token.'
            );
        }
    }
}
