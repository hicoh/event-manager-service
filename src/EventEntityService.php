<?php

namespace HiCo\EventManagerService;

use GuzzleHttp\Client as GuzzleClient;
use HiCo\EventManagerClient\Model\UpdateEventEntityRequest;
use HiCo\EventManagerClient\Service\EventEntityApi;

class EventEntityService
{
    private Client $client;

    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->client = new Client($guzzleClient);
    }

    public function patchEventEntities(UpdateEventEntityRequest $updateEventEntities, string $organisationId = null): void
    {
        $apiInstance = new EventEntityApi($this->client::getClient(), $this->client::getConfig());
        $apiInstance->updateEventEntity($updateEventEntities, $organisationId);
    }

}
