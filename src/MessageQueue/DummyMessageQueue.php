<?php

namespace BroadHorizon\EventSourcing\MessageQueue;

class DummyMessageQueue implements MessageQueueInterface
{
    /**
     * @var bool
     */
    private $dump;
    /**
     * __construct method.
     *
     * @param bool $dump
     */
    public function __construct(bool $dump = false)
    {
        $this->dump = $dump;
    }

    /**
     * @param string $body
     * @param array $headers
     * @param string $routingKey
     * @param string $exchange
     */
    public function publish(string $body, array $headers = [], string $routingKey = '', string $exchange = '')
    {
        if (!$this->dump) {
            return;
        }
        echo ('var_dump($headers): ');
        var_dump($headers);

        echo ('var_dump($body): ');
        var_dump($body);
    }
}
