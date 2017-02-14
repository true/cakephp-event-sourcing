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

    protected $_defaultConfig = [
        'vhost' => '/',
    ];

    /**
     * __construct method.
     *
     * @param array $config Configuration array
     */
    public function __construct(array $config = [])
    {
        $this->setConfig($config);
        $this->client = new Client([
            'host' => $this->getConfig('host'),
            'vhost' => $this->getConfig('vhost'),
            'username' => $this->getConfig('username'),
            'password' => $this->getConfig('password'),
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

        $this->channel->publish($body, $headers, $exchange ?? (string) $this->getConfig('exchange'), $routingKey);
    }

    private function connect()
    {
        $this->client->connect();
        $this->channel = $this->client->channel();
    }

    /**
     * @return bool
     */
    private function isConnected()
    {
        return $this->client->isConnected();
    }
}
