<?php

namespace BroadHorizon\EventSourcing;

interface CommandInterface
{
    public function getPayload() : Payload;

    static function fromPayload(Payload $payload): CommandInterface;

    public static function fromEventPayload(string $type, string $namespace, int $version, Payload $payload) : CommandInterface;

    public static function type(CommandInterface $command);

    public static function classFromType(string $type, string $namespace);
}
