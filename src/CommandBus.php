<?php

namespace BroadHorizon\EventSourcing;

class CommandBus
{
    /**
     * @var callable
     */
    private $handler;

    public function __construct(callable $handler)
    {
        $this->handler = $handler;
    }


    public function handle(CommandInterface $command)
    {
        $this->handler($command);
    }
}
