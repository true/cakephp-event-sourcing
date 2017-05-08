<?php

namespace BroadHorizon\EventSourcing;

use Cake\Core\App;
use Cake\Utility\Inflector;
use DateTimeInterface;

abstract class Event implements EventInterface
{
    protected $id;

    /**
     * @var int
     */
    protected $version;

    protected $date;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @param int $version
     */
    public function setVersion(int $version)
    {
        $this->version = $version;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date)
    {
        $this->date = $date;
    }

    /**
     * @param string $type
     * @param string $namespace
     * @param int $version
     * @param Payload $payload
     *
     * @return EventInterface
     */
    public static function fromEventPayload(string $type, string $namespace, int $version, string $id, Payload $payload): EventInterface
    {
        /** @var EventInterface $class */
        $class = static::classFromType($type, $namespace);
        $event = $class::fromPayload($id, $payload);

        $event->setVersion($version);

        return $event;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return Inflector::dasherize(App::shortName(get_class($this), 'Model/Event'));
    }

    /**
     * @param string $type
     * @param string $namespace
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public static function classFromType(string $type, string $namespace): string
    {
        list($entity, $event) = explode('/', $type);

        $entity = Inflector::camelize($entity);
        $event = ucfirst(Inflector::variable($event));

        $class = str_replace('\\', '/', $namespace) . '.' . $entity . '/' . $event;
        $className = App::className($class, 'Model/Event');
        if (!$className) {
            throw new \RuntimeException(sprintf('Class %s not found for type: %s', $className, $type));
        }

        return $className;
    }
}
