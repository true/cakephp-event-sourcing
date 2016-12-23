<?php

namespace BroadHorizon\EventSourcing\Http;

use BroadHorizon\EventSourcing\CommandBusAwareInterface;
use Cake\Http\ControllerFactory as CakeControllerFactory;
use Cake\Network\Request;
use Cake\Network\Response;
use League\Tactician\CommandBus;

class ControllerFactory extends CakeControllerFactory
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function create(Request $request, Response $response)
    {
        $controller = parent::create($request, $response);
        if ($controller instanceof CommandBusAwareInterface) {
            $controller->setCommandBus($this->commandBus);
        }

        return $controller;
    }
}
