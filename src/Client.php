<?php

namespace HiCo\EventManagerService;

use GuzzleHttp\Client as GuzzleClient;
use HiCo\EventManagerClient\Configuration;

class Client
{
    public static Configuration $config;
    private static GuzzleClient $client;

    public function __construct(GuzzleClient $guzzleClient)
    {
        self::$config = Configuration::getDefaultConfiguration()->setHost(getenv('HIGHCOHESION_API_HOST'))
            ->setApiKey('apikey', getenv('HIGHCOHESION_API_KEY'));
        self::$client = $guzzleClient;
    }

    public static function getConfig(): Configuration
    {
        return self::$config;
    }

    public static function getClient(): GuzzleClient
    {
        return self::$client;
    }
}
