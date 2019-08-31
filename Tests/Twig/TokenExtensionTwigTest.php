<?php

namespace Atournayre\ToolboxBundle\Tests\Twig;

use Atournayre\ToolboxBundle\Service\Token\Token;
use Atournayre\ToolboxBundle\Twig\TokenExtension;
use Exception;
use PHPUnit\Framework\TestCase;

class TokenExtensionTwigTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTokenFilter()
    {
        $tokenExtension = new TokenExtension(new Token());
        $this->assertRegExp('/test\&([0-9]*)/', $tokenExtension->tokenFilter('test'));
    }

    /**
     * @throws Exception
     */
    public function testTokenFilterWithPipeAsBeforeCharacter()
    {
        $tokenExtension = new TokenExtension(new Token());
        $this->assertRegExp('/test\|([0-9]*)/', $tokenExtension->tokenFilter('test', '|'));
    }

    /**
     * @throws Exception
     */
    public function testTokenFilterWithEmptyStringAsBeforeCharacter()
    {
        $this->expectException(Exception::class);
        $tokenExtension = new TokenExtension(new Token());
        $tokenExtension->tokenFilter('test', '');
    }

    /**
     * @throws Exception
     */
    public function testTokenFunction()
    {
        $tokenExtension = new TokenExtension(new Token());
        $this->assertRegExp('/test\?([0-9]*)/', $tokenExtension->tokenFunction('test'));
    }

    /**
     * @throws Exception
     */
    public function testTokenFunctionWithArobaseAsBeforeCharacter()
    {
        $tokenExtension = new TokenExtension(new Token());
        $this->assertRegExp('/test\@([0-9]*)/', $tokenExtension->tokenFunction('test', '@'));
    }

    /**
     * @throws Exception
     */
    public function testTokenFunctionWithEmptyStringAsBeforeCharacter()
    {
        $this->expectException(Exception::class);
        $tokenExtension = new TokenExtension(new Token());
        $tokenExtension->tokenFunction('test', '');
    }
}
