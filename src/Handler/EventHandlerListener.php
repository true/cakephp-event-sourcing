<?php

namespace BroadHorizon\EventSourcing\Handler;

use BroadHorizon\EventSourcing\EventInterface;
use BroadHorizon\EventSourcing\Listener;
use League\Tactician\Exception\CanNotInvokeHandlerException;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;

/**
 * The "core" CommandBus. Locates the appropriate handler and executes command.
 */
class EventHandlerListener implements Listener
{
    /**
     * @var CommandNameExtractor
     */
    private $commandNameExtractor;

    /**
     * @var HandlerLocator
     */
    private $handlerLocator;

    /**
     * @var MethodNameInflector
     */
    private $methodNameInflector;

    /**
     * @param CommandNameExtractor $commandNameExtractor
     * @param HandlerLocator       $handlerLocator
     * @param MethodNameInflector  $methodNameInflector
     */
    public function __construct(
        CommandNameExtractor $commandNameExtractor,
        HandlerLocator $handlerLocator,
        MethodNameInflector $methodNameInflector
    ) {
        $this->commandNameExtractor = $commandNameExtractor;
        $this->handlerLocator = $handlerLocator;
        $this->methodNameInflector = $methodNameInflector;
    }

    /**
     * Executes a command and optionally returns a value
     *
     * @param EventInterface $event
     * @param callable $next
     *
     * @return mixed
     *
     * @throws CanNotInvokeHandlerException
     */
    public function apply(EventInterface $event, callable $next)
    {
        $commandName = $this->commandNameExtractor->extract($event);
        $handler = $this->handlerLocator->getHandlerForCommand($commandName);
        $methodName = $this->methodNameInflector->inflect($event, $handler);

        // is_callable is used here instead of method_exists, as method_exists
        // will fail when given a handler that relies on __call.
        if (!is_callable([$handler, $methodName])) {
            throw CanNotInvokeHandlerException::forCommand(
                $event,
                "Method '{$methodName}' does not exist on handler"
            );
        }

        return $handler->{$methodName}($event);
    }
}
