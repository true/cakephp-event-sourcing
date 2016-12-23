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
class ApplyClassNameInflector implements MethodNameInflector
{
    /**
     * {@inheritdoc}
     */
    public function inflect($event, $eventHandler)
    {
        $eventName = get_class($event);

        // If class name has a namespace separator, only take last portion
        if (strpos($eventName, '\\') !== false) {
            $eventName = substr($eventName, strrpos($eventName, '\\') + 1);
        }

        return 'apply' . $eventName;
    }
}
