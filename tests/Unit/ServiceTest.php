<?php

namespace HiCo\Message\Unit\Serializer;

use HiCo\EventManagerService\Service;
use PHPUnit\Framework\TestCase;

class MessageSerializerTest extends TestCase
{
    public function testConstruct()
    {
        $test = new Service();
        var_dump($test->getConfig());
        $this->assertEquals($test->getConfig()->getHost(), 'test');
    }
}