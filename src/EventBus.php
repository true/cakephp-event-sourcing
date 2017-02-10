<?php

namespace BroadHorizon\EventSourcing;

use League\Tactician\Exception\InvalidMiddlewareException;

/**
 * Receives a command and sends it through a chain of listeners for processing.
 *
 * @final
 */
class EventBus
{
    /**
     * @var callable
     */
    private $middlewareChain;

    /**
     * @param Listener[] $listeners
     */
    public function __construct(array $listeners)
    {
        $this->middlewareChain = $this->createExecutionChain($listeners);
    }

    /**
     * Publishes the given event.
     *
     * @param EventInterface $event
     *
     * @return mixed
     */
    public function publish(EventInterface $event)
    {
        $middlewareChain = $this->middlewareChain;

        return $middlewareChain($event);
    }

    /**
     * @param Listener[] $listeners
     *
     * @return callable
     */
    private function createExecutionChain($listeners)
    {
        $lastCallable = function () {
            // the final callable is a no-op
        };

        while ($listener = array_pop($listeners)) {
            if (!$listener instanceof Listener) {
                throw InvalidMiddlewareException::forMiddleware($listener);
            }

            $lastCallable = function ($event) use ($listener, $lastCallable) {
                return $listener->apply($event, $lastCallable);
            };
        }

        return $lastCallable;
    }
}
