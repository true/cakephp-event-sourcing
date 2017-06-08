<?php

namespace BroadHorizon\EventSourcing;

interface CommandInterface
{
    public function toPayload(): Payload;

    public static function fromPayload(Payload $payload): CommandInterface;

    public static function fromEventPayload(string $type, string $namespace, Payload $payload): CommandInterface;

    public static function type(CommandInterface $command);

    public static function classFromType(string $type, string $namespace);
}
