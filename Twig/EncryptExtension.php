<?php

namespace Atournayre\ToolboxBundle\Twig;

use Atournayre\ToolboxBundle\Encryptor\EncryptorInterface;
use Twig\TwigFilter;
use Twig_Extension;
use Twig_SimpleFilter;

class EncryptExtension extends Twig_Extension
{
    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    /**
     * EncryptExtension constructor.
     *
     * @param EncryptorInterface $encryptor
     */
    public function __construct(EncryptorInterface $encryptor)
    {
        $this->encryptor = $encryptor;
    }

    /**
     * @return array|TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new Twig_SimpleFilter('decrypt', [
                $this,
                'decryptFilter',
            ]),
        ];
    }

    /**
     * @param string $data
     *
     * @return string
     */
    public function decryptFilter(string $data): string
    {
        return $this->encryptor->decrypt($data);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'atournayre_toolbox_encrypt_extension';
    }
}
