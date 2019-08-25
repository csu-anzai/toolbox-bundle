<?php

namespace Atournayre\ToolboxBundle\Encryptor;

use Exception;
use Atournayre\ToolboxBundle\Subscribers\DoctrineEncryptSubscriberInterface;

class OpenSslEncryptor implements EncryptorInterface
{
    const METHOD = 'aes-256-cbc';

    /**
     * @var string|null
     */
    private $secretKey;

    /**
     * OpenSslEncryptor constructor.
     *
     * @param string|null $secretKey
     */
    public function __construct(string $secretKey = null)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return self::class . ':' . self::METHOD;
    }

    /**
     * @param string $data
     *
     * @return string
     * @throws Exception
     */
    public function encrypt(string $data): string
    {
        if (null === $data) {
            return $data;
        }

        if (is_object($data)) {
            throw new Exception('You cannot encrypt an object.');
        }

        // If the value already has the suffix <ENC> then ignore.
        if (substr($data, -5) === DoctrineEncryptSubscriberInterface::ENCRYPTED_SUFFIX) {
            return $data;
        }

        $key = $this->getSecretKey();

        // Create a cipher of the appropriate length for this method.
        $ivsize = openssl_cipher_iv_length(self::METHOD);
        $iv = openssl_random_pseudo_bytes($ivsize);

        // Create the encryption.
        $ciphertext = openssl_encrypt(
            $data,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        return base64_encode($iv . $ciphertext) . DoctrineEncryptSubscriberInterface::ENCRYPTED_SUFFIX;
    }

    /**
     * @param string $data
     *
     * @return string
     * @throws Exception
     */
    public function decrypt($data): string
    {
        if (null === $data) {
            return $data;
        }

        if (is_object($data)) {
            throw new Exception('You cannot decrypt an object.');
        }

        // If the value does not have the suffix <ENC> then ignore.
        if (substr($data, -5) !== DoctrineEncryptSubscriberInterface::ENCRYPTED_SUFFIX) {
            return $data;
        }

        $data = substr($data, 0, -5);

        // If the data is just <ENC> the return null;
        if (empty($data)) {
            return $data;
        }

        $key = $this->getSecretKey();

        $data = base64_decode($data);

        $ivsize = openssl_cipher_iv_length(self::METHOD);
        $iv = mb_substr($data, 0, $ivsize, '8bit');
        $ciphertext = mb_substr($data, $ivsize, null, '8bit');

        $decrypted = openssl_decrypt(
            $ciphertext,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        return $decrypted;
    }

    /**
     * Get the secret key.
     *
     * Decode the parameters file base64 key.
     * Check that the key is 256 bit.
     *
     * @return string
     * @throws Exception
     */
    private function getSecretKey()
    {
        if (null === $this->secretKey) {
            throw new Exception('The configuration "encrypt_key" is missing.
            Use cli command "php bin/console encrypt:genkey" to create a key.');
        }

        // Decode the key
        $key = base64_decode($this->secretKey);

        $keyLengthOctet = mb_strlen($key, '8bit');

        if (32 !== $keyLengthOctet) {
            throw new Exception(sprintf('Needs a 256-bit key, %sbit given!', ($keyLengthOctet * 8)));
        }

        return $key;
    }
}
