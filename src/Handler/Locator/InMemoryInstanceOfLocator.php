<?php

namespace BroadHorizon\EventSourcing\Handler\Locator;

use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;

class InMemoryInstanceOfLocator implements HandlerLocator
{
    /**
     * @var object[]
     */
    protected $handlers = [];

    /**
     * @param array $commandClassToHandlerMap
     */
    public function __construct(array $commandClassToHandlerMap = [])
    {
        $this->addHandlers($commandClassToHandlerMap);
    }

    /**
     * Bind a handler instance to receive all commands with a certain class.
     *
     * @param object $handler Handler to receive class
     * @param string $commandClassName Command class e.g. "My\TaskAddedCommand"
     */
    public function addHandler($handler, $commandClassName)
    {
        $this->handlers[$commandClassName] = $handler;
    }

    /**
     * Allows you to add multiple handlers at once.
     *
     * The map should be an array in the format of:
     *  [
     *      AddTaskCommand::class      => $someHandlerInstance,
     *      CompleteTaskCommand::class => $someHandlerInstance,
     *  ]
     *
     * @param array $commandClassToHandlerMap
     */
    protected function addHandlers(array $commandClassToHandlerMap)
    {
        foreach ($commandClassToHandlerMap as $commandClass => $handler) {
            $this->addHandler($handler, $commandClass);
        }
    }

    /**
     * Returns the handler bound to the command's class name.
     *
     * @param string $commandName
     *
     * @return object
     */
    public function getHandlerForCommand($commandName)
    {
        foreach ($this->handlers as $baseClass => $handler) {
            if (is_subclass_of($commandName, $baseClass)) {
                return $handler;
            }
        }

        throw MissingHandlerException::forCommand($commandName);
    }
}
