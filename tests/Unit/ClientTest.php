<?php

namespace Unit;

use HiCo\EventManagerService\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testConstruct()
    {
        $test = new Client(new \GuzzleHttp\Client());
        $this->assertEquals($test::getConfig()->getHost(), false);
    }
}