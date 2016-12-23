<?php

namespace BroadHorizon\EventSourcing;

use League\Tactician\CommandBus;

interface CommandBusAwareInterface
{
    public function getCommandBus();

    public function setCommandBus(CommandBus $commandBus);
}
