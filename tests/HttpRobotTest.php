<?php

namespace Javanile\IpQueue\Tests;

use Javanile\HttpRobot\HttpRobot;
use PHPUnit\Framework\TestCase;

class HttpRobotTest extends TestCase
{
    public function testGetApi()
    {
        $app = new MysqlImport(
            [ 'REQUEST_METHOD' => 'GET' ],
            [ 'Host' => 'test.ipqueue.com' ]
        );

        $this->assertEquals($app->run(), "");
    }
}
