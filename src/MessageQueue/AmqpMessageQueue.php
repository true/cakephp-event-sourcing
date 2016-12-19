<?php

namespace BroadHorizon\EventSourcing\MessageQueue;

use Bunny\Client;

class AmqpMessageQueue extends BaseMessageQueue
{

    /**
     * @var \Bunny\Client
     */
    protected $_client;

    /**
     * @var \Bunny\Channel
     */
    protected $_channel;

    public function connect()
    {
        try {
            $this->_client->connect();
        } catch (\Exception $exception) {
            debug($exception);
        }

        $this->_channel = $this->_client->channel();
    }

    public function isConnected()
    {
        if (!$this->_client) {
            $this->_client = new Client([
                'host' => $this->config('host'),
                'vhost' => $this->config('path'),
                'username' => $this->config('username'),
                'password' => $this->config('password'),
            ]);
        }

        return $this->_client->isConnected();
    }

    public function publish($body, array $headers = [], $routingKey = '', $exchange = null)
    {
        if (!$this->isConnected()) {
            $this->connect();
        }

        $this->_channel->publish($body, $headers, $exchange ?? $this->config('exchange'), $routingKey);;
    }
}
