<?php

namespace Atournayre\ToolboxBundle\Twig;

use Twig_Extension;
use Twig_Function;

class TagExtension extends Twig_Extension
{
    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new Twig_Function('spanWithTitle', [$this, 'spanWithTitle'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param string      $content
     * @param string|null $title
     *
     * @return string
     */
    public function spanWithTitle(string $content, string $title = null): string
    {
        return sprintf('<span title="%s">%s</span>', $title ?? $content, $content);
    }
}
