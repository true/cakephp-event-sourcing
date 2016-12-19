<?php

namespace BroadHorizon\EventSourcing\MessageQueue;

use Cake\Core\InstanceConfigTrait;

class BaseMessageQueue implements MessageQueueInterface
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
     * __construct method
     *
     * @param array $config Configuration array
     */
    public function __construct(array $config = [])
    {
        $this->config($config);
    }

    public function publish($body, array $headers = [], $exchange = '', $routingKey = '')
    {

    }
}
