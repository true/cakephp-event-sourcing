<?php

namespace BroadHorizon\EventSourcing;

use Cake\Core\App;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;

abstract class Command implements CommandInterface
{
    abstract public function toPayload(): Payload;

    abstract public static function fromPayload(Payload $payload): CommandInterface;

    abstract public static function validator(): Validator;

    public static function fromEventPayload(string $type, string $namespace, Payload $payload): CommandInterface
    {
        /** @var Event $class */
        $class = static::classFromType($type, $namespace);
        $event = $class::fromPayload($payload);

        $event->setVersion($version);

        return $event;
    }

    public static function type(CommandInterface $command)
    {
        return Inflector::dasherize(App::shortName(get_class($command), 'Model/Command'));
    }

    public static function classFromType(string $type, string $namespace)
    {
        list($entity, $event) = explode('/', $type);

        $entity = Inflector::camelize($entity);
        $event = ucfirst(Inflector::variable($event));

        $namespace = str_replace('\\', '/', $namespace);

        return App::className($namespace . '.' . $entity . '/' . $event, 'Model/Command');
    }
}
