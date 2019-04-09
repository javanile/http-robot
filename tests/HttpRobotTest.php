<?php

namespace Javanile\IpQueue\Tests;

use donatj\MockWebServer\MockWebServer;
use donatj\MockWebServer\Response;
use Javanile\HttpRobot\HttpRobot;
use PHPUnit\Framework\TestCase;

class HttpRobotTest extends TestCase
{
    /** @var MockWebServer */
    protected static $server;

    public static function setUpBeforeClass()
    {
        self::$server = new MockWebServer();
        self::$server->start();
        self::$server->setResponseOfPath('/', new Response(
            file_get_contents(__DIR__.'/fixtures/index.html')
        ));
        self::$server->setResponseOfPath('/form', new Response(
            file_get_contents(__DIR__.'/fixtures/form.html')
        ));
    }

    public function testRawGet()
    {
        $robot = new HttpRobot([
            'base_uri' => self::$server->getServerRoot(),
            'cookies'  => true,
        ]);

        $this->assertNotEmpty($robot->get('page'));
    }

    public function testRawPost()
    {
        $robot = new HttpRobot([
            'base_uri' => self::$server->getServerRoot(),
            'cookies'  => true,
        ]);

        $this->assertNotEmpty($robot->post('page'));
    }

    public function testFormGet()
    {
        $robot = new HttpRobot([
            'base_uri' => self::$server->getServerRoot(),
            'cookies'  => true,
        ]);

        $this->assertEquals($robot->get('form', 'website'), 'www.mytestco.com');
        $this->assertEquals(
            $robot->get('/form', ['website', 'phone']),
            ['website' => 'www.mytestco.com', 'phone' => 9898878787]
        );
    }

    public function testFormPost()
    {
        $robot = new HttpRobot([
            'base_uri' => self::$server->getServerRoot(),
            'cookies'  => true,
        ]);

        $this->assertEquals($robot->post('form', [], 'website'), 'www.mytestco.com');
        $this->assertEquals(
            $robot->post('/form', [], ['website', 'phone']),
            ['website' => 'www.mytestco.com', 'phone' => 9898878787]
        );
    }

    public function testTextValue()
    {
        $robot = new HttpRobot([
            'base_uri' => self::$server->getServerRoot(),
            'cookies'  => true,
        ]);

        $text = $robot->get('/', '@text');
        $this->assertEquals($text, file_get_contents(__DIR__.'/fixtures/index.text'));
    }
}
