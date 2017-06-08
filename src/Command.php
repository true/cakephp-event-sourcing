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
        /** @var Command $class */
        $class = static::classFromType($type, $namespace);
        $command = $class::fromPayload($payload);

        return $command;
    }

    public static function type(CommandInterface $command)
    {
        return Inflector::dasherize(App::shortName(get_class($command), 'Command'));
    }

    public static function classFromType(string $type, string $namespace)
    {
        $command = ucfirst(Inflector::variable($type));

        $namespace = str_replace('\\', '/', $namespace);

        return App::className($namespace . '.' . $command, 'Command');
    }
}
