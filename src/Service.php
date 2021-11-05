<?php

namespace HiCo\EventManagerService;

use GuzzleHttp\Client;
use HiCo\EventManagerClient\ApiException;
use HiCo\EventManagerClient\Configuration;
use HiCo\EventManagerClient\Model\AsyncResponse;
use HiCo\EventManagerClient\Model\Event;
use HiCo\EventManagerClient\Model\JobRequest;
use HiCo\EventManagerClient\Model\UpdateEventEntityRequest;
use HiCo\EventManagerClient\Model\UpdateEventRequest;
use HiCo\EventManagerClient\Service\EventApi;
use HiCo\EventManagerClient\Service\EventEntityApi;
use HiCo\EventManagerClient\Service\JobApi;
use HiCo\EventManagerClient\Service\KeyApi;

class Service
{
    private static Configuration $config;
    private Client $client;

    public function __construct()
    {
        self::$config = Configuration::getDefaultConfiguration()->setHost(getenv('HIGHCOHESION_API_HOST'))
            ->setApiKey('apikey', getenv('HIGHCOHESION_API_KEY'));
        $this->client = new Client();
    }

    public function getConfig(): Configuration
    {
        return self::$config;
    }

    /**
     * @param object[]|null $payloadInList
     *
     * @throws ApiException
     */
    public function createJob(string $streamId, ?array $payloadInList): AsyncResponse
    {
        $apiInstance = new JobApi($this->client, self::$config);
        $jobRequest = (new JobRequest())->setStreamId($streamId)->setPayloadInList($payloadInList);

        return $apiInstance->createJob($jobRequest);
    }

    public function getEvent(string $eventId): ?Event
    {
        $apiInstance = new EventApi($this->client, self::$config);
        $event = $apiInstance->getEventById($eventId);
        if ($event instanceof Event) {
            return $event;
        }

        return null;
    }

    public function patchEvent(?UpdateEventRequest $updateEventRequest): void
    {
        if ($updateEventRequest) {
            $apiInstance = new EventApi($this->client, self::$config);
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
            $apiInstance = new EventEntityApi($this->client, self::$config);
            foreach ($updateEventEntities as $updateEventEntity) {
                $apiInstance->updateEventEntity($updateEventEntity);
            }
        }
    }

    /**
     * @param string $id
     *
     * @return array
     * @throws ApiException
     */
    public function getKey(string $id): array
    {
        $apInstance = new KeyApi($this->client, self::$config);

        return json_decode($apInstance->getKey($id)[0], true);
    }
}
