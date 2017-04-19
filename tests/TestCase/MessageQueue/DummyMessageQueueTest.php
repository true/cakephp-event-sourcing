<?php

namespace BroadHorizon\EventSourcing\Test\TestCase\MessageQueue;

use BroadHorizon\EventSourcing\MessageQueue\DummyMessageQueue;
use Cake\TestSuite\TestCase;

class DummyMessageQueueTest extends TestCase
{
    public function testQuietPublish()
    {
        $dummyMessageQueue = new DummyMessageQueue();
        $dummyMessageQueue->publish('test!');
    }

    public function testLoggingPublish()
    {
        $dummyMessageQueue = new DummyMessageQueue([
            'log' => true,
        ]);
        $this->expectOutputRegex('/test!/');

        $dummyMessageQueue->publish('test!');
    }
}
