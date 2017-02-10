<?php

namespace BroadHorizon\EventSourcing\MessageQueue;

use Cake\Core\App;
use Cake\Core\ObjectRegistry;
use RuntimeException;

/**
 * Registry of loaded message queues.
 */
class MessageQueueRegistry extends ObjectRegistry
{
    /**
     * Resolve a logger classname.
     *
     * Part of the template method for Cake\Core\ObjectRegistry::load()
     *
     * @param string $class partial classname to resolve
     *
     * @return string|false either the correct classname or false
     */
    protected function _resolveClassName($class)
    {
        if (is_object($class)) {
            return $class;
        }

        return App::className($class, 'MessageQueue', 'MessageQueue');
    }

    /**
     * Throws an exception when a logger is missing.
     *
     * Part of the template method for Cake\Core\ObjectRegistry::load()
     *
     * @param string $class the classname that is missing
     * @param string $plugin the plugin the logger is missing in
     *
     * @throws \RuntimeException
     */
    protected function _throwMissingClassError($class, $plugin)
    {
        throw new RuntimeException(sprintf('Could not load class %s', $class));
    }

    /**
     * Create the logger instance.
     *
     * Part of the template method for Cake\Core\ObjectRegistry::load()
     *
     * @param string|\Psr\Log\LoggerInterface $class the classname or object to make
     * @param string $alias the alias of the object
     * @param array $settings an array of settings to use for the logger
     *
     * @return \Psr\Log\LoggerInterface the constructed logger class
     *
     * @throws \RuntimeException when an object doesn't implement the correct interface
     */
    protected function _create($class, $alias, $settings)
    {
        if (is_callable($class)) {
            $class = $class($alias);
        }

        if (is_object($class)) {
            $instance = $class;
        }

        if (!isset($instance)) {
            $instance = new $class($settings);
        }

        if ($instance instanceof MessageQueueInterface) {
            return $instance;
        }

        throw new RuntimeException(
            'Loggers must implement MessageQueueInterface.'
        );
    }

    /**
     * Remove a single logger from the registry.
     *
     * @param string $name the logger name
     */
    public function unload($name)
    {
        unset($this->_loaded[$name]);
    }
}
