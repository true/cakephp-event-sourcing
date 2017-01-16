<?php

namespace BroadHorizon\EventSourcing;

use Cake\Core\App;
use Cake\Utility\Inflector;

abstract class Event implements EventInterface
{
    protected $version;

    public function getVersion() : int
    {
        return $this->version;
    }

    public function setVersion(int $version)
    {
        $this->version = $version;
    }

    public static function fromEventPayload(string $type, string $namespace, int $version, array $payload) : EventInterface
    {
        /** @var Event $class */
        $class = static::classFromType($type, $namespace);
        $event = $class::fromPayload($payload);

        $event->setVersion($version);

        return $event;
    }

    public static function type(EventInterface $event)
    {
        return Inflector::dasherize(App::shortName(get_class($event), 'Model/Event'));
    }

    public static function classFromType(string $type, string $namespace)
    {
        list($entity, $event) = explode('/', $type);

        $entity = Inflector::camelize($entity);
        $event = ucfirst(Inflector::variable($event));

        $namespace = str_replace('\\', '/', $namespace);

        return App::className($namespace . '.' . $entity . '/' . $event, 'Model/Event');
    }
}
