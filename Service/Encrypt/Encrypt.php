<?php

namespace Atournayre\ToolboxBundle\Service\Encrypt;

class Encrypt
{
    /**
     * @var string
     */
    private $salt;

    /**
     * @var int int
     */
    private $ivSize;

    /**
     * @var string
     */
    private $iv;

    /**
     * Encrypt constructor.
     *
     * @param string $salt
     */
    public function __construct(string $salt)
    {
        $this->salt = $salt;
        $this->ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $this->iv = mcrypt_create_iv($this->ivSize, MCRYPT_RAND);
    }

    /**
     * @param Encrypt $crypt
     * @param string  $value
     * @param int     $valueLength
     *
     * @return null|string
     */
    public static function getReadable(Encrypt $crypt, $value, $valueLength)
    {
        if (strlen($value) > $valueLength) {
            return $crypt->decode($value);
        }

        return $value;
    }

    /**
     * @param string $data
     *
     * @return string
     */
    public function encode($data)
    {
        if (null === $data || '' === $data) {
            return '';
        }

        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->salt, $data, MCRYPT_MODE_CBC, $this->iv);
        $ciphertext = $this->iv . $ciphertext;
        return base64_encode($ciphertext);
    }

    /**
     * @param string $data
     *
     * @return null|string
     */
    public function decode($data)
    {
        if (null === $data || '' === $data) {
            return '';
        }

        $ciphertextDec = base64_decode($data);

        $ivDec = substr($ciphertextDec, 0, $this->ivSize);
        $ciphertextDec = substr($ciphertextDec, $this->ivSize);

        if (0 === strlen($ciphertextDec)) {
            return null;
        }

        $plaintextDec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->salt, $ciphertextDec, MCRYPT_MODE_CBC, $ivDec);

        return rtrim($plaintextDec, "\x00..\x1F");
    }
}
