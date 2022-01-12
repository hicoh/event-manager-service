<?php

namespace HiCo\EventManagerService;

use GuzzleHttp\Client as GuzzleClient;
use HiCo\EventManagerClient\Model\AsyncResponse;
use HiCo\EventManagerClient\Service\AggregateApi;

class AggregateService
{
    private Client $client;

    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->client = new Client($guzzleClient);
    }

    public function aggregate(string $organisationId, string $streamId, string $jobId): AsyncResponse
    {
        $apiInstance = new AggregateApi(
            $this->client::getClient(),
            $this->client::getConfig(),
        );

        return $apiInstance->getAggregateEvents($organisationId, $streamId, $jobId);
    }
}
