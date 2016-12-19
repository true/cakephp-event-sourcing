<?php

namespace BroadHorizon\EventSourcing\Form;

use BroadHorizon\EventSourcing\CommandBus;
use BroadHorizon\EventSourcing\CommandInterface;
use BroadHorizon\EventSourcing\Exception\ValidationException;
use BroadHorizon\EventSourcing\Payload;
use Cake\Form\Form;

class CommandForm extends Form
{
    /**
     * @var string
     */
    protected $commandClassName;
    /**
     * @var CommandBus
     */
    protected $commandBus;

    public function __construct(string $commandClassName, CommandBus $commandBus)
    {
        $this->commandClassName = $commandClassName;

        $this->validator($commandClassName::validator());
        $this->commandBus = $commandBus;
    }

    protected function _execute(array $data)
    {
        /** @var CommandInterface $commandClassName */
        $commandClassName = $this->commandClassName;

        $this->commandBus->handle($commandClassName::fromPayload(new Payload($data)));

        return true;
    }

    public function execute(array $data)
    {
        $result = parent::execute($data);
        if (!$result) {
            throw new ValidationException($this->errors());
        }

        return true;
    }
}
