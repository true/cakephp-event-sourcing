<?php

namespace BroadHorizon\EventSourcing\MessageQueue;

interface MessageQueueInterface
{
    public function publish($body, array $headers = [], $routingKey = '');
}
