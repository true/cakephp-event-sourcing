<?php

namespace BroadHorizon\EventSourcing\MessageQueue;

use Cake\Core\InstanceConfigTrait;

class DummyMessageQueue implements MessageQueueInterface
{
    use InstanceConfigTrait;

    protected $_defaultConfig = [
        'log' => false,
    ];

    /**
     * __construct method.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    /**
     * @param string $body
     * @param array $headers
     * @param string $routingKey
     * @param string $exchange
     */
    public function publish(string $body, array $headers = [], string $routingKey = '', string $exchange = '')
    {
        if (!$this->getConfig('log')) {
            return;
        }

        echo 'var_dump($headers): ';
        var_dump($headers);

        echo 'var_dump($body): ';
        var_dump($body);
    }
}
