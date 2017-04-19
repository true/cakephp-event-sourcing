<?php

namespace BroadHorizon\EventSourcing\MessageQueue;

interface MessageQueueInterface
{
    /**
     * MessageQueueInterface constructor.
     *
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * @param string $body
     * @param array $headers
     * @param string $routingKey
     * @param string $exchange
     */
    public function publish(string $body, array $headers = [], string $routingKey = '', string $exchange = null);
}
