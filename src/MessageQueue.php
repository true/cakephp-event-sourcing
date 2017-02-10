<?php

namespace BroadHorizon\EventSourcing;

use BroadHorizon\EventSourcing\MessageQueue\MessageQueueRegistry;
use Cake\Core\StaticConfigTrait;
use Cake\Datasource\Exception\MissingDatasourceConfigException;

class MessageQueue
{
    use StaticConfigTrait {
//        config as protected _config;
    }

    /**
     * An array mapping url schemes to fully qualified Log engine class names.
     *
     * @var array
     */
    protected static $_dsnClassMap = [
        'amqp' => 'BroadHorizon\EventSourcing\MessageQueue\AmqpMessageQueue',
    ];

    /**
     * LogEngineRegistry class.
     *
     * @var \Cake\Log\LogEngineRegistry
     */
    protected static $_registry;

//    public static function config($key, $config = null)
//    {
//        debug($key);
//        debug($config);
//    }

    /**
     * Get a connection.
     *
     * If the connection has not been constructed an instance will be added
     * to the registry. This method will use any aliases that have been
     * defined. If you want the original unaliased connections pass `false`
     * as second parameter.
     *
     * @param string $name the connection name
     *
     * @return \BroadHorizon\EventSourcing\MessageQueue\MessageQueueInterface a message queue object
     *
     * @throws \Cake\Datasource\Exception\MissingDatasourceConfigException when config
     * data is missing
     */
    public static function get($name)
    {
        if (empty(static::$_config[$name])) {
            throw new MissingDatasourceConfigException(['name' => $name]);
        }
        if (empty(static::$_registry)) {
            static::$_registry = new MessageQueueRegistry();
        }
        if (isset(static::$_registry->{$name})) {
            return static::$_registry->{$name};
        }

        return static::$_registry->load($name, static::$_config[$name]);
    }
}
