<?php

namespace Atournayre\ToolboxBundle\Service\Insee;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class InseeSirene extends Insee
{
    const URL_API_SIRENE = 'https://api.insee.fr/entreprises/sirene/V3';
    const URL_API_SIREN = self::URL_API_SIRENE.'/siren';
    const URL_API_SIRET = self::URL_API_SIRENE.'/siret';

    /**
     * @param string $urlApi
     * @param string $sirene
     * @param string $token
     *
     * @return ResponseInterface
     */
    public function callGet(string $urlApi, string $sirene, string $token): ResponseInterface
    {
        return (new Client())
            ->get($this->url($urlApi, $sirene), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'http_errors' => false,
            ]);
    }

    /**
     * @param string $urlApi
     * @param string $sirene
     *
     * @return string
     */
    private function url(string $urlApi, string $sirene): string
    {
        return $urlApi . DIRECTORY_SEPARATOR . $sirene;
    }

    /**
     * @param string $urlApi
     * @param string $sirene
     * @param string $token
     *
     * @return object
     */
    public function get(string $urlApi, string $sirene, string $token): object
    {
        $result = $this->callGet($urlApi, $this->clean($sirene), $token);
        return $this->decode($result);
    }

    /**
     * @param string $sirene
     *
     * @return string
     */
    public function clean(string $sirene): string
    {
        return str_replace(' ', '', $sirene);
    }
}
