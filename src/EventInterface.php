<?php

namespace BroadHorizon\EventSourcing;

use DateTimeInterface;

interface EventInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return int
     */
    public function getVersion(): int;

    /**
     * @param int $version
     */
    public function setVersion(int $version);

    public function getDate(): DateTimeInterface;

    public function setDate(DateTimeInterface $date);

    /**
     * @return Payload
     */
    public function toPayload(): Payload;

    /**
     * @param $id
     * @param Payload $payload
     *
     * @return EventInterface
     */
    public static function fromPayload($id, Payload $payload): EventInterface;

    /**
     * @param string $type
     * @param string $namespace
     * @param int $version
     * @param string $id
     * @param Payload $payload
     *
     * @return EventInterface
     */
    public static function fromEventPayload(string $type, string $namespace, int $version, string $id, Payload $payload): EventInterface;

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
