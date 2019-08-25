<?php

namespace Atournayre\ToolboxBundle\Service\Insee;

use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class InseeToken extends Insee
{
    const URL_API = 'https://api.insee.fr/token';

    /**
     * @var string
     */
    private $consumerKey;

    /**
     * @var string
     */
    private $consumerSecret;

    /**
     * InseeToken constructor.
     *
     * @param string $consumerKey
     * @param string $consumerSecret
     */
    public function __construct(string $consumerKey, string $consumerSecret)
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function encode(): string
    {
        if (null === $this->consumerKey || null === $this->consumerSecret) {
            throw new Exception('INSEE credentials are invalid.');
        }
        return base64_encode($this->consumerKey.':'.$this->consumerSecret);
    }

    /**
     * @param string $token
     *
     * @return ResponseInterface
     */
    public function callApi(string $token): ResponseInterface
    {
        return (new Client())
            ->post(self::URL_API, [
                'headers' => [
                    'Content-Type'  => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic '.$token,
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function get(): string
    {
        $result = $this->callApi($this->encode());
        $result = $this->decode($result);
        return $result->access_token;
    }
}
