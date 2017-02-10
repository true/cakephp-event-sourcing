<?php

namespace BroadHorizon\EventSourcing;

use Cake\Core\App;
use Cake\Utility\Inflector;

abstract class Event implements EventInterface
{
    /**
     * @var int
     */
    protected $version;

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

    /**
     * @param string $type
     * @param string $namespace
     * @param int $version
     * @param array $payload
     *
     * @return EventInterface
     */
    public static function fromEventPayload(string $type, string $namespace, int $version, string $id, array $payload): EventInterface
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
