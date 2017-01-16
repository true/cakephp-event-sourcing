<?php

namespace BroadHorizon\EventSourcing;

interface EventInterface
{
    public function getVersion() : int;

    public function setVersion(int $version);

    public function toPayload() : array;

    static function fromPayload($id, array $payload): EventInterface;

    public static function fromEventPayload(string $type, string $namespace, int $version, array $payload) : EventInterface;

    public static function type(EventInterface $event);

    public static function classFromType(string $type, string $namespace);
}
