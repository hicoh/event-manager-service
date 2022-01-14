<?php

namespace HiCo\EventManagerService;

use GuzzleHttp\Client as GuzzleClient;
use HiCo\EventManagerClient\Model\ReplicateWebhook;
use HiCo\EventManagerClient\Service\WebhookApi;

class WebhookService
{
    private Client $client;

    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->client = new Client($guzzleClient);
    }

    /**
     * @throws \HiCo\EventManagerClient\ApiException
     */
    public function replicateStaticWebhook(string $organisationId, string $jobId, ?object $payloadIn)
    {
        $apiInstance = new WebhookApi($this->client::getClient(), $this->client::getConfig());
        $request = (new ReplicateWebhook())->setJobId($jobId)->setPayloadIn($payloadIn);

        $apiInstance->replicateStaticWebhook($request, $organisationId);
    }

    /**
     * @throws \HiCo\EventManagerClient\ApiException
     */
    public function replicateDynamicWebhook(string $organisationId, string $jobId, ?object $payloadIn)
    {
        $apiInstance = new WebhookApi($this->client::getClient(), $this->client::getConfig());
        $request = (new ReplicateWebhook())->setJobId($jobId)->setPayloadIn($payloadIn);

        $apiInstance->replicateDynamicWebhook($request, $organisationId);
    }
}