<?php

namespace Atournayre\ToolboxBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig_Function;

class TagNullableExtension extends AbstractExtension implements ExtensionInterface
{
    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new Twig_Function('p', [$this, 'p'], ['is_safe' => ['html']]),
            new Twig_Function('div', [$this, 'div'], ['is_safe' => ['html']]),
            new Twig_Function('span', [$this, 'span'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param string      $class
     * @param string|null $content
     * @param string|null $id
     *
     * @return string
     */
    public function p(string $class, string $content = null, string $id = null): string
    {
        return $this->displayTag('p', $class, $content, $id);
    }

    /**
     * @param string      $class
     * @param string|null $content
     * @param string|null $id
     *
     * @return string
     */
    public function div(string $class, string $content = null, string $id = null): string
    {
        return $this->displayTag('div', $class, $content, $id);
    }

    /**
     * @param string      $class
     * @param string|null $content
     * @param string|null $id
     *
     * @return string
     */
    public function span(string $class, string $content = null, string $id = null): string
    {
        return $this->displayTag('span', $class, $content, $id);
    }

    /**
     * @param string      $tag
     * @param string      $class
     * @param string|null $content
     * @param string|null $id
     *
     * @return string
     */
    private function displayTag(string $tag, string $class, string $content = null, string $id = null)
    {
        return null === $content
            ? ''
            : $this->tag($tag, $class, $content, $id);
    }

    /**
     * @param string      $tag
     * @param string      $class
     * @param string      $content
     * @param string|null $id
     *
     * @return string
     */
    private function tag(string $tag, string $class, string $content, string $id = null): string
    {
        return null === $id
            ? sprintf('<%s class="%s">%s</%s>', $tag, $class, $content, $tag)
            : sprintf('<%s class="%s" id="%s">%s</%s>', $tag, $class, $id, $content, $tag);
    }
}
