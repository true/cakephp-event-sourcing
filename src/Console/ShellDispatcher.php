<?php

namespace BroadHorizon\EventSourcing\Console;

use BroadHorizon\EventSourcing\CommandBusAwareInterface;
use Cake\Console\ShellDispatcher as CakeShellDispatcher;
use League\Tactician\CommandBus;

class ShellDispatcher extends CakeShellDispatcher
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    public function __construct(CommandBus $commandBus, $args = [], $bootstrap = true)
    {
        parent::__construct($args, $bootstrap);

        $this->commandBus = $commandBus;
    }

    /**
     * Run the dispatcher.
     *
     * @param CommandBus $commandBus
     * @param array $argv The argv from PHP
     * @param array $extra Extra parameters
     *
     * @return int the exit code of the shell process
     */
    public static function runWithCommandBus(CommandBus $commandBus, $argv, $extra = [])
    {
        $dispatcher = new static($commandBus, $argv);

        return $dispatcher->dispatch($extra);
    }

    protected function _createShell($className, $shortName)
    {
        $shell = parent::_createShell($className, $shortName);
        if ($shell instanceof CommandBusAwareInterface) {
            $shell->setCommandBus($this->commandBus);
        }

        return $shell;
    }
}
