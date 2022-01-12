<?php

namespace HiCo\EventManagerService;

use GuzzleHttp\Client as GuzzleClient;
use HiCo\EventManagerClient\Service\OrganisationApi;

class OrganisationService
{
    private Client $client;

    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->client = new Client($guzzleClient);
    }

    public function createOrganisation(string $organisationId): void
    {
        $apiInstance = new OrganisationApi($this->client::getClient(), $this->client::getConfig());

        $apiInstance->createOrganisationIndex($organisationId);
    }
}
