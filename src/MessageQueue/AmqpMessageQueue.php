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
    protected $_client;

    /**
     * @var \Bunny\Channel
     */
    protected $_channel;

    /**
     * __construct method
     *
     * @param array $config Configuration array
     */
    public function __construct(array $config = [])
    {
        $this->config($config);
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

        $this->_channel->publish($body, $headers, $exchange ?? (string)$this->config('exchange'), $routingKey);;
    }

    /**
     *
     */
    private function connect()
    {
        try {
            $this->getClient()->connect();
        } catch (\Exception $exception) {
            debug($exception);
        }

        $this->_channel = $this->_client->channel();
    }

    /**
     * @return bool
     */
    private function isConnected()
    {
        return $this->getClient()->isConnected();
    }

    /**
     * @return Client
     */
    private function getClient()
    {
        if (! $this->_client) {
            $this->_client = new Client([
                'host' => $this->config('host'),
                'vhost' => $this->config('path'),
                'username' => $this->config('username'),
                'password' => $this->config('password'),
            ]);
        }

        return $this->_client;
    }
}
