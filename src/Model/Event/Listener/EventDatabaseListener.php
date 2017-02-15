<?php

namespace BroadHorizon\EventSourcing\Model\Event\Listener;

use BroadHorizon\EventSourcing\EventInterface;
use BroadHorizon\EventSourcing\Listener;
use BroadHorizon\EventSourcing\Model\Table\EventsTable;
use InvalidArgumentException;

class EventDatabaseListener implements Listener
{
    /**
     * @var EventsTable
     */
    private $eventsTable;

    public function __construct(EventsTable $eventsTable)
    {
        $this->eventsTable = $eventsTable;
    }

    /**
     * @param EventInterface $event
     * @param callable $next
     *
     * @return mixed
     */
    public function apply(EventInterface $event, callable $next)
    {
        $data = [
            'entity_id' => $event->getId(),
            'version' => $event->getVersion(),
            'type' => $event->getType(),
            'payload' => $event->toPayload(),
        ];

        $newEntity = $this->eventsTable->newEntity($data);

        $success = $this->eventsTable->save($newEntity);
        if (!$success) {
            debug($newEntity->getErrors());

            exit();
        }

        return $next($event);
    }
}
