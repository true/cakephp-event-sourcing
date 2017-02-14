<?php

namespace BroadHorizon\EventSourcing\Test\TestCase\MessageQueue;

use BroadHorizon\EventSourcing\MessageQueue\AmqpMessageQueue;
use Cake\TestSuite\TestCase;

class AmqpMessageQueueTest extends TestCase
{
    /**
     * @expectedException \Bunny\Exception\ClientException
     */
    public function testConnectWithError()
    {
        $messageQueue = new AmqpMessageQueue([
            'username' => 'non_existing'
        ]);
        $messageQueue->publish('test!');
    }

    public function testPublish()
    {
        $messageQueue = new AmqpMessageQueue();
        $messageQueue->publish('test!');
    }
}
