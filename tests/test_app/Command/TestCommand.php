<?php

namespace App\Command;

use BroadHorizon\EventSourcing\CommandInterface;
use BroadHorizon\EventSourcing\Payload;
use Cake\Validation\Validator;

class TestCommand extends AbstractCommand
{

    public function toPayload(): Payload
    {
        // TODO: Implement getPayload() method.
    }

    public static function fromPayload(Payload $payload): CommandInterface
    {
        // TODO: Implement fromPayload() method.
    }

    public static function validator(): Validator
    {
        // TODO: Implement validator() method.
    }
}
