<?php

namespace HiCo\EventManagerService;

use GuzzleHttp\Client as GuzzleClient;
use HiCo\EventManagerClient\ApiException;
use HiCo\EventManagerClient\Model\AsyncResponse;
use HiCo\EventManagerClient\Model\JobRequest;
use HiCo\EventManagerClient\Service\JobApi;

class JobService
{
    private Client $client;

    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->client = new Client($guzzleClient);
    }

    /**
     * @param object[]|null $payloadInList
     *
     * @throws ApiException
     */
    public function createJob(string $streamId, ?array $payloadInList): AsyncResponse
    {
        $apiInstance = new JobApi($this->client::getClient(), $this->client::getConfig());
        $jobRequest = (new JobRequest())->setStreamId($streamId)->setPayloadInList($payloadInList);

        return $apiInstance->createJob($jobRequest);
    }

    public function deleteJob(?string $organisationId, ?string $id, string $streamId, ?string $status, ?string $dueAt): void
    {
        $apiInstance = new JobApi($this->client::getClient(), $this->client::getConfig());
        $apiInstance->deleteJob($organisationId, $id, $streamId, $status, $dueAt);
    }
}
