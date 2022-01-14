<?php

namespace HiCo\EventManagerService;

use GuzzleHttp\Client as GuzzleClient;
use HiCo\EventManagerClient\Model\AsyncResponse;
use HiCo\EventManagerClient\Model\ReplicateEventRequest;
use HiCo\EventManagerClient\Model\ReplicateParentAggregateEventRequest;
use HiCo\EventManagerClient\Service\AggregateApi;

class AggregateService
{
    private Client $client;

    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->client = new Client($guzzleClient);
    }

    /**
     * @throws \HiCo\EventManagerClient\ApiException
     */
    public function aggregate(string $organisationId, string $streamId, string $jobId): AsyncResponse
    {
        $apiInstance = new AggregateApi($this->client::getClient(), $this->client::getConfig());

        return $apiInstance->getAggregateEvents($organisationId, $streamId, $jobId);
    }

    /**
     * @throws \HiCo\EventManagerClient\ApiException
     */
    public function replicateParentAggregateEvent(string $organisationId, string $originalEventId): AsyncResponse
    {
        $apiInstance = new AggregateApi($this->client::getClient(), $this->client::getConfig());
        $request = (new ReplicateParentAggregateEventRequest())->setOriginalEventId($originalEventId);

        return $apiInstance->replicateParentAggregateEvent($request, $organisationId);
    }

    /**
     * @throws \HiCo\EventManagerClient\ApiException
     */
    public function replicateChildAggregateEvent(string $organisationId, string $originalEventId, object $payloadIn): AsyncResponse
    {
        $apiInstance = new AggregateApi($this->client::getClient(), $this->client::getConfig());
        $request = (new ReplicateEventRequest())->setOriginalEventId($originalEventId)->setPayloadIn($payloadIn);

        return $apiInstance->replicateChildAggregateEvent($organisationId, $request);
    }
}
