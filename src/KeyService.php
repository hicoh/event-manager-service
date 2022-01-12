<?php

namespace HiCo\EventManagerService;

use GuzzleHttp\Client as GuzzleClient;
use HiCo\EventManagerClient\ApiException;
use HiCo\EventManagerClient\Service\KeyApi;

class KeyService
{
    private Client $client;

    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->client = new Client($guzzleClient);
    }

    /**
     * @throws ApiException
     */
    public function getKey(string $id): array
    {
        $apInstance = new KeyApi($this->client::getClient(), $this->client::getConfig());

        return json_decode($apInstance->getKey($id)[0], true);
    }
}
