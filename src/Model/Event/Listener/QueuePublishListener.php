<?php

namespace BroadHorizon\EventSourcing\Model\Event\Listener;

use BroadHorizon\EventSourcing\EventInterface;
use BroadHorizon\EventSourcing\Listener;
use BroadHorizon\EventSourcing\MessageQueue\MessageQueueInterface;
use Cake\Core\InstanceConfigTrait;

class QueuePublishListener implements Listener
{
    use InstanceConfigTrait;

    /**
     * @var MessageQueueInterface
     */
    private $queue;

    /**
     * QueuePublishListener constructor.
     *
     * @param MessageQueueInterface $queue
     * @param array $config
     */
    public function __construct(MessageQueueInterface $queue, array $config)
    {
        $this->setConfig($config);
        if (!$this->getConfig('application')) {
            throw new \RuntimeException('application config key is required');
        }
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
            throw new \InvalidArgumentException(
                'json_encode error: ' . json_last_error_msg()
            );
        }

        $this->queue->publish(
            $payload,
            [
                'entity_id' => $event->getId(),
                'application' => $this->getConfig('application'),
                'type' => $event->getType(),
                'version' => $event->getVersion(),
                'content-type' => 'application/json',
            ]
        );

        return $next($event);
    }
}
