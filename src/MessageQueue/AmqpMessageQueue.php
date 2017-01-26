<?php

namespace BroadHorizon\EventSourcing\MessageQueue;

use Bunny\Client;
use Cake\Core\InstanceConfigTrait;

class AmqpMessageQueue implements MessageQueueInterface
{
    use InstanceConfigTrait;

    /**
     * @var \Bunny\Client
     */
    protected $client;

    /**
     * @var \Bunny\Channel
     */
    protected $channel;

    /**
     * __construct method
     *
     * @param array $config Configuration array
     */
    public function __construct(array $config = [])
    {
        $this->config($config);
        $this->client = new Client([
            'host' => $this->config('host'),
            'vhost' => $this->config('path'),
            'username' => $this->config('username'),
            'password' => $this->config('password'),
        ]);
    }

    /**
     * @param string $body
     * @param array $headers
     * @param string $routingKey
     * @param string $exchange
     */
    public function publish(string $body, array $headers = [], string $routingKey = '', string $exchange = '')
    {
        if (!$this->isConnected()) {
            $this->connect();
        }

        $this->channel->publish($body, $headers, $exchange ?? (string)$this->config('exchange'), $routingKey);;
    }

    /**
     *
     */
    private function connect()
    {
        try {
            $this->client->connect();
            $this->channel = $this->client->channel();
        } catch (\Exception $exception) {
            debug($exception);
        }
    }

    /**
     * @return bool
     */
    private function isConnected()
    {
        return $this->client->isConnected();
    }
}
