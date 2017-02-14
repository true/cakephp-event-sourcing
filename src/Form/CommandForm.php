<?php

namespace BroadHorizon\EventSourcing\Form;

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

    public function __construct(string $commandClassName)
    {
        $this->commandClassName = $commandClassName;

        $this->validator($commandClassName::validator());
    }

    /**
     * @param array $data
     *
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
     *
     * @return CommandInterface
     *
     * @throws ValidationException
     */
    public function execute(array $data)
    {
        /** @var bool|CommandInterface $result */
        $result = parent::execute($data);
        if (!$result) {
            throw new ValidationException($this->errors());
        }

        return $result;
    }
}
