<?php

namespace Atournayre\ToolboxBundle\Service\Google\Calendar;

use Exception;
use Google_Client;
use Google_Exception;
use Google_Service_Calendar;
use Symfony\Component\Filesystem\Filesystem;

class GoogleClientService
{
    const CREDENTIALS_JSON = 'credentials.json';
    const TOKEN_JSON       = 'token.json';

    /**
     * @var array
     */
    private static $scopes = [
        Google_Service_Calendar::CALENDAR_EVENTS,
        Google_Service_Calendar::CALENDAR,
    ];

    /**
     * @var string
     */
    private $applicationName;

    /**
     * @var string
     */
    private $configDirectory;

    /**
     * @var string
     */
    private $projectDirectory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * GoogleClientService constructor.
     *
     * @param string     $applicationName
     * @param string     $configDirectory
     * @param string     $projectDirectory
     * @param Filesystem $filesystem
     */
    public function __construct(
        string $applicationName,
        string $configDirectory,
        string $projectDirectory,
        Filesystem $filesystem
    ) {
        $this->applicationName = $applicationName;
        $this->configDirectory = $configDirectory;
        $this->projectDirectory = $projectDirectory;
        $this->filesystem = $filesystem;
    }

    /**
     * Returns an authorized API client.
     *
     * @return Google_Client the authorized client object
     * @throws Google_Exception
     */
    public function getGoogleClient(): Google_Client
    {
        $client = $this->createClient();
        $tokenFilePath = $this->getTokenFilePath();
        $client = $this->addToken($client, $tokenFilePath);
        return $client;
    }

    /**
     * @return Google_Client
     * @throws Google_Exception
     */
    public function createClient(): Google_Client
    {
        $client = new Google_Client();
        $client->setApplicationName($this->applicationName);
        $client->setScopes(self::$scopes);
        $client->setAuthConfig($this->credentialsFilePath());
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        return $client;
    }

    /**
     * @return string
     */
    public function credentialsFilePath(): string
    {
        return $this->projectDirectory . $this->configDirectory . DIRECTORY_SEPARATOR . self::CREDENTIALS_JSON;
    }

    /**
     * @return string
     */
    public function getTokenFilePath(): string
    {
        return $this->projectDirectory . $this->configDirectory . DIRECTORY_SEPARATOR . self::TOKEN_JSON;
    }

    /**
     * @param Google_Client $client
     * @param string        $tokenFilePath
     *
     * @return Google_Client
     */
    public function addToken(Google_Client $client, string $tokenFilePath): Google_Client
    {
        if (file_exists($tokenFilePath)) {
            $tokenGoogle = json_decode(file_get_contents($tokenFilePath), true);
            $client->setAccessToken($tokenGoogle);
        }

        return $client;
    }

    /**
     * @param Google_Client $client
     * @param string        $tokenFilePath
     */
    public function saveTokenFile(Google_Client $client, string $tokenFilePath): void
    {
        $this->removeTokenFile($tokenFilePath);
        $this->filesystem->appendToFile($tokenFilePath, json_encode($client->getAccessToken()));
    }

    /**
     * @param array $tokenGoogle
     *
     * @throws Exception
     */
    public function checkTokenValidity(array $tokenGoogle): void
    {
        if (array_key_exists('error', $tokenGoogle)) {
            throw new Exception(join(', ', $tokenGoogle));
        }
    }

    /**
     * @param string $tokenFilePath
     */
    public function removeTokenFile(string $tokenFilePath): void
    {
        $this->filesystem->remove($tokenFilePath);
    }
}
