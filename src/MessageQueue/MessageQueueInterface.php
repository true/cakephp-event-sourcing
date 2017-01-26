<?php

namespace BroadHorizon\EventSourcing\MessageQueue;

interface MessageQueueInterface
{
    /**
     * @param string $body
     * @param array $headers
     * @param string $routingKey
     * @param string $exchange
     */
    public function publish(string $body, array $headers = [], string $routingKey = '', string $exchange = '');
}
