<?php

namespace HiCo\EventManagerService;

use GuzzleHttp\Client as GuzzleClient;
use HiCo\EventManagerClient\ApiException;
use HiCo\EventManagerClient\Model\ScheduleConfiguration;
use HiCo\EventManagerClient\Model\ScheduleConfigurationRequest;
use HiCo\EventManagerClient\Service\StreamApi;


class StreamService
{
    private Client $client;

    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->client = new Client($guzzleClient);
    }

    public function updateScheduleConfigurationAttributes(
        string $organisationId, string $streamId, string $scheduledOption, bool $active
    ) {
        $apiInstance = new StreamApi($this->client::getClient(), $this->client::getConfig());
        $scheduleConfigurationRequest = new ScheduleConfigurationRequest(
            [
                'streamId' => $streamId,
                'scheduledOption' => $scheduledOption,
                'active' => $active,
            ]
        );
        $apiInstance->updateScheduleConfigurationAttributes($organisationId, $scheduleConfigurationRequest);
    }

    public function createScheduleConfiguration(string $organisationId, string $streamId, string $scheduledOption, bool $active)
    {
        $apiInstance = new StreamApi($this->client::getClient(), $this->client::getConfig());
        $scheduleConfigurationRequest = new ScheduleConfigurationRequest(
            [
                'streamId' => $streamId,
                'scheduledOption' => $scheduledOption,
                'active' => $active,
            ]
        );
        $apiInstance->createScheduleConfiguration($organisationId, $scheduleConfigurationRequest);
    }

    public function deleteScheduleConfiguration(string $organisationId, string $streamId)
    {
        $apiInstance = new StreamApi($this->client::getClient(), $this->client::getConfig());
        $apiInstance->deleteScheduleConfiguration($streamId, $organisationId);
    }

    public function getScheduleConfiguration(string $organisationId, string $streamId): ?ScheduleConfiguration
    {
        $apiInstance = new StreamApi($this->client::getClient(), $this->client::getConfig());
        try {
                return $apiInstance->getScheduleConfiguration($streamId, $organisationId);
        } catch (ApiException $exception) {
            if (404 !== $exception->getCode()) {
                throw $exception;
            }
        }

        return null;
    }
}