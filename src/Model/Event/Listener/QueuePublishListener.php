<?php

namespace BroadHorizon\EventSourcing\Model\Event\Listener;

use BroadHorizon\EventSourcing\EventInterface;
use BroadHorizon\EventSourcing\Listener;
use BroadHorizon\EventSourcing\MessageQueue\MessageQueueInterface;
use InvalidArgumentException;

class QueuePublishListener implements Listener
{
    /**
     * @var MessageQueueInterface
     */
    private $queue;

    /**
     * @var string
     */
    private $applicationName;

    /**
     * QueuePublishListener constructor.
     *
     * @param MessageQueueInterface $queue
     * @param string $applicationName
     */
    public function __construct(MessageQueueInterface $queue, string $applicationName)
    {
        $this->applicationName = $applicationName;
        $this->queue = $queue;
    }

    /**
     * @param EventInterface $event
     * @param callable $next
     *
     * @return mixed
     */
    public function apply(EventInterface $event, callable $next)
    {
        $payload = json_encode($event->toPayload());
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidArgumentException(
                'json_encode error: ' . json_last_error_msg()
            );
        }

        $this->queue->publish(
            $payload,
            [
                'entity_id' => $event->getId(),
                'application' => $this->applicationName,
                'type' => $event->getType(),
                'version' => $event->getVersion(),
                'content-type' => 'application/json',
                'delivery-mode' => 2,
            ]
        );

        return $next($event);
    }
}
