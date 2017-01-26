<?php

namespace BroadHorizon\EventSourcing\MessageQueue;

use Bunny\Client;
use Cake\Core\InstanceConfigTrait;

class AmqpMessageQueue implements MessageQueueInterface
{
    use InstanceConfigTrait;

    /**
     * Default config for this class
     *
     * @var array
     */
    protected $_defaultConfig = [
        'exchange' => '',
        'queue' => '',
    ];

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
     * @param $body
     * @param array $headers
     * @param string $routingKey
     * @param null $exchange
     */
    public function publish($body, array $headers = [], $routingKey = '', $exchange = null)
    {
        if (!$this->isConnected()) {
            $this->connect();
        }

        $this->_channel->publish($body, $headers, $exchange ?? $this->config('exchange'), $routingKey);;
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
