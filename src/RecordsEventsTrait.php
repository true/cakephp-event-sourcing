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
        $this->unpublishedEvents[] = $event;

        $event->setVersion($this->revision_number + 1);
        $this->applyEvent($event);
    }

    /**
     * @return EventInterface[]
     */
    public function getUnpublishedEvents()
    {
        return $this->unpublishedEvents;
    }

    /**
     * @param EventInterface $event
     */
    public function applyEvent(EventInterface $event)
    {
        if ($event->getVersion() !== ($this->revision_number + 1)) {
            throw new RuntimeException(sprintf(
                'Invalid event version %s, current entity version is %',
                $event->getVersion(),
                $this->revision_number
            ));
        }
        $methodName = $this->getApplyMethodName($event);
        if (!method_exists($this, $methodName)) {
            throw new RuntimeException(sprintf(
                'Method %s not found.',
                $methodName
            ));
        }
        call_user_func([$this, $methodName], $event);
        $this->revision_number = $event->getVersion();
        $this->events[] = $event;
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
