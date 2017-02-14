<?php

namespace BroadHorizon\EventSourcing\Test\TestCase;

use BroadHorizon\EventSourcing\MessageQueue;
use Cake\TestSuite\TestCase;

class MessageQueueTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        MessageQueue::setConfig('test', [
            'className' => 'BroadHorizon\EventSourcing\MessageQueue\DummyMessageQueue',
        ]);
    }

    public function tearDown()
    {
        parent::tearDown();

        MessageQueue::drop('test');
    }

    /**
     * Test parseDsn method.
     *
     * @return void
     */
    public function testParseDsn()
    {
        $result = MessageQueue::parseDsn('amqp://username:password@localhost/test?log=1');
        $expected = [
            'scheme' => 'amqp',
            'className' => 'BroadHorizon\EventSourcing\MessageQueue\AmqpMessageQueue',
            'host' => 'localhost',
            'username' => 'username',
            'password' => 'password',
            'log' => '1',
            'vhost' => '/test',
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * Test get() failing on missing config.
     *
     * @expectedException \BroadHorizon\EventSourcing\MessageQueue\Exception\MissingMessageQueueConfigException
     * @expectedExceptionMessage The message queue configuration "test_variant" was not found.
     * @return void
     */
    public function testGetFailOnMissingConfig()
    {
        MessageQueue::get('test_variant');
    }

    /**
     * Test loading configured connections.
     *
     * @return void
     */
    public function testGet()
    {
        $config = MessageQueue::getConfig('test');
        $this->skipIf(empty($config), 'No test config, skipping');

        $ds = MessageQueue::get('test');
        $this->assertSame($ds, MessageQueue::get('test'));
        $this->assertInstanceOf('BroadHorizon\EventSourcing\MessageQueue\MessageQueueInterface', $ds);
    }
}
