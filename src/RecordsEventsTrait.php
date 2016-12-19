<?php

namespace BroadHorizon\EventSourcing;

use RuntimeException;

trait RecordsEventsTrait
{
    /**
     * @var EventInterface[]
     */
    protected $unpublishedEvents = [];

    /**
     * @param EventInterface $event
     */
    public function recordThat(EventInterface $event)
    {
        $this->events[] = $event;
        $this->unpublishedEvents[] = $event;

        $event->setVersion(count($this->events));
        $this->applyEvent($event);
    }

    /**
     * @return EventInterface[]
     */
    public function getUnpublishedEvents()
    {
        $events = $this->unpublishedEvents;
//        $this->unpublishedEvents = [];

        return $events;
    }

    /**
     * @param EventInterface $event
     *
     * @return void
     */
    protected function applyEvent(EventInterface $event)
    {
        $methodName = $this->getApplyMethodName($event);
        if (! method_exists($this, $methodName)) {
            throw new RuntimeException(sprintf(
                'Method %s not found.',
                $methodName
            ));
        }
        call_user_func([$this, $methodName], $event);
    }

    /**
     * @param EventInterface $event
     *
     * @return string
     */
    protected function getApplyMethodName(EventInterface $event)
    {
        $classParts = explode('\\', get_class($event));

        return 'apply' . end($classParts) . 'Event';
    }
}
