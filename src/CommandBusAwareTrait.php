<?php

namespace BroadHorizon\EventSourcing;

use League\Tactician\CommandBus;

trait CommandBusAwareTrait
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    public function getCommandBus(): CommandBus
    {
        return $this->commandBus;
    }

    public function setCommandBus(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;

        return $this;
    }
}
