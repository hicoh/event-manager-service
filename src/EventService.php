<?php

namespace HiCo\EventManagerService;

use GuzzleHttp\Client as GuzzleClient;
use HiCo\EventManagerClient\ApiException;
use HiCo\EventManagerClient\Model\Event;
use HiCo\EventManagerClient\Model\ReplicateEventRequest;
use HiCo\EventManagerClient\Model\UpdateEventEntityRequest;
use HiCo\EventManagerClient\Model\UpdateEventRequest;
use HiCo\EventManagerClient\Service\EventApi;
use HiCo\EventManagerClient\Service\EventEntityApi;


class EventService
{
    private Client $client;

    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->client = new Client($guzzleClient);
    }

    public function getEvent(string $eventId): ?Event
    {
        $apiInstance = new EventApi($this->client::getClient(), $this->client::getConfig());
        $event = $apiInstance->getEventById($eventId);
        if ($event instanceof Event) {
            return $event;
        }

        return null;
    }

    public function patchEvent(?UpdateEventRequest $updateEventRequest): void
    {
        if ($updateEventRequest) {
            $apiInstance = new EventApi($this->client::getClient(), $this->client::getConfig());
            $apiInstance->updateEvent($updateEventRequest);
        }
    }

    /**
     * @param UpdateEventEntityRequest[]|null $updateEventEntities
     *
     * @throws ApiException
     */
    public function patchEventEntities(?array $updateEventEntities): void
    {
        if ($updateEventEntities) {
            $apiInstance = new EventEntityApi($this->client::getClient(), $this->client::getConfig());
            foreach ($updateEventEntities as $updateEventEntity) {
                $apiInstance->updateEventEntity($updateEventEntity);
            }
        }
    }

    public function replicateEvent(?string $organisationId, string $jobId, string $originalEventId, object $payloadIn)
    {
        $apiInstance = new EventApi($this->client::getClient(), $this->client::getConfig());
        $replicateEventRequest = (new ReplicateEventRequest())
            ->setOriginalEventId($originalEventId)->setJobId($jobId)->setPayloadIn($payloadIn);
        $apiInstance->replicateEvent($organisationId, $replicateEventRequest);
    }
}