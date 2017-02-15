<?php

namespace BroadHorizon\EventSourcing\MessageQueue\Exception;

use Cake\Core\Exception\Exception;

/**
 * Exception class to be thrown when a message queue configuration is not found.
 */
class MissingMessageQueueConfigException extends Exception
{
    protected $_messageTemplate = 'The message queue configuration "%s" was not found.';
}
