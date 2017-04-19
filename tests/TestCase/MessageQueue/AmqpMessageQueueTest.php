<?php

namespace BroadHorizon\EventSourcing\Test\TestCase\MessageQueue;

use BroadHorizon\EventSourcing\MessageQueue;
use BroadHorizon\EventSourcing\MessageQueue\AmqpMessageQueue;
use Cake\TestSuite\TestCase;

class AmqpMessageQueueTest extends TestCase
{
    /**
     * @expectedException \Bunny\Exception\ClientException
     */
    public function testConnectWithError()
    {
        $config = MessageQueue::parseDsn(env('AMQP_URL'));

        $messageQueue = new AmqpMessageQueue([
            'host' => $config['host'],
            'port' => $config['port'],
            'vhost' => $config['vhost'],
            'username' => 'non_existing',
            'password' => $config['password'],
        ]);
        $messageQueue->publish('test!');
    }

    public function testPublish()
    {
        $config = MessageQueue::parseDsn(env('AMQP_URL'));

        $messageQueue = new AmqpMessageQueue([
            'host' => $config['host'],
            'port' => $config['port'],
            'vhost' => $config['vhost'],
            'username' => $config['username'],
            'password' => $config['password'],
        ]);
        $messageQueue->publish('test!');
    }
}
