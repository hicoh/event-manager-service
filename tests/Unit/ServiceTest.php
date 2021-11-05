<?php

namespace Unit;

use HiCo\EventManagerService\Service;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    public function testConstruct()
    {
        $test = new Service();
        var_dump($test->getConfig());
        $this->assertEquals($test->getConfig()->getHost(), false);
    }
}