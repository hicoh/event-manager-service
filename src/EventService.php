<?php

namespace HiCo\EventManagerService;

use GuzzleHttp\Client as GuzzleClient;
use HiCo\EventManagerClient\ApiException;
use HiCo\EventManagerClient\Model\AsyncResponse;
use HiCo\EventManagerClient\Model\Event;
use HiCo\EventManagerClient\Model\PostEventRequest;
use HiCo\EventManagerClient\Model\ReplicateEventRequest;
use HiCo\EventManagerClient\Model\UpdateChildEventRequest;
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

    public function postEvent(string $organisationId, string $streamId, string $jobId, object $payloadIn): AsyncResponse
    {
        $apiInstance = new EventApi($this->client::getClient(), $this->client::getConfig());

        $request = (new PostEventRequest())->setStreamId($streamId)->setJobId($jobId)->setPayloadIn($payloadIn);
        return $apiInstance->postEvent($request, $organisationId);
    }

    public function patchEvent(?UpdateEventRequest $updateEventRequest, string $organisationId = null): void
    {
        if ($updateEventRequest) {
            $apiInstance = new EventApi($this->client::getClient(), $this->client::getConfig());
            $apiInstance->updateEvent($updateEventRequest, $organisationId);
        }
    }

    public function updateChildEvent(
        string $organisationId,
        string $parentId,
        string $entityName,
        string $status,
        string $message,
        string $destinationId
    ) {
        $apiInstance = new EventApi(
            $this->client::getClient(),
            $this->client::getConfig(),
        );
        $request = (new UpdateChildEventRequest())->setParentId($parentId)
            ->setEntityName($entityName)
            ->setStatus($status)
            ->setMessage($message)
            ->setDestinationId($destinationId);
        $apiInstance->updateChildEvent($request, $organisationId);
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

    /**
     * @throws ApiException
     */
    public function replicateEvent(?string $organisationId, string $originalEventId, object $payloadIn): AsyncResponse
    {
        $apiInstance = new EventApi($this->client::getClient(), $this->client::getConfig());
        $replicateEventRequest = (new ReplicateEventRequest())->setOriginalEventId($originalEventId)->setPayloadIn($payloadIn);

        return $apiInstance->replicateEvent($organisationId, $replicateEventRequest);
    }
}
