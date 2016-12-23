<?php

namespace BroadHorizon\EventSourcing\Handler\MethodNameInflector;

use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;

/**
 * Assumes the method is handle + the last portion of the class name.
 *
 * Examples:
 *  - \MyGlobalEvent              => $handler->handleMyGlobalEvent()
 *  - \My\App\TaskCompletedEvent  => $handler->handleTaskCompletedEvent()
 */
class ApplyInflector implements MethodNameInflector
{
    /**
     * {@inheritdoc}
     */
    public function inflect($event, $eventHandler)
    {
        return 'apply';
    }
}
