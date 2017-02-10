<?php

namespace BroadHorizon\EventSourcing;

interface EventInterface
{
    /**
     * @return int
     */
    public function getVersion(): int;

    /**
     * @param int $version
     */
    public function setVersion(int $version);

    /**
     * @return array
     */
    public function toPayload(): array;

    /**
     * @param $id
     * @param array $payload
     *
     * @return EventInterface
     */
    public static function fromPayload($id, array $payload): EventInterface;

    /**
     * @param string $type
     * @param string $namespace
     * @param int $version
     * @param string $id
     * @param array $payload
     *
     * @return EventInterface
     */
    public static function fromEventPayload(string $type, string $namespace, int $version, string $id, array $payload): EventInterface;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     * @param string $namespace
     *
     * @return string
     */
    public static function classFromType(string $type, string $namespace): string;
}
