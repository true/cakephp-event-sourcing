<?php

namespace BroadHorizon\EventSourcing\Form;

use BroadHorizon\EventSourcing\CommandInterface;
use BroadHorizon\EventSourcing\Exception\ValidationException;
use BroadHorizon\EventSourcing\Payload;
use Cake\Form\Form;
use League\Tactician\CommandBus;

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

    /**
     * @param array $data
     * @return CommandInterface
     */
    protected function _execute(array $data)
    {
        /** @var CommandInterface $commandClassName */
        $commandClassName = $this->commandClassName;

        return $commandClassName::fromPayload(new Payload($data));
    }

    /**
     * @param array $data
     * @return CommandInterface
     * @throws ValidationException
     */
    public function execute(array $data)
    {
        $result = parent::execute($data);
        if (!$result) {
            throw new ValidationException($this->errors());
        }

        if ($result instanceof CommandInterface) {
            return $result;
        }

        throw new \UnexpectedValueException();
    }
}
