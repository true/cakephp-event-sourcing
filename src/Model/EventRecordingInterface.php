<?php

namespace BroadHorizon\EventSourcing\Model;

use BroadHorizon\EventSourcing\EventInterface;

interface EventRecordingInterface
{
    /**
     * @param EventInterface $event
     */
    public function recordThat(EventInterface $event);

    /**
     * @return EventInterface[]
     */
    public function getUnpublishedEvents();
}
