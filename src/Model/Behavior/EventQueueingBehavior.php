<?php

namespace BroadHorizon\EventSourcing\Model\Behavior;

use BroadHorizon\EventSourcing\Event;
use BroadHorizon\EventSourcing\MessageQueue;
use BroadHorizon\EventSourcing\Model\EventRecordingInterface;
use Cake\Event\Event as CakeEvent;
use Cake\ORM\Behavior;

class EventQueueingBehavior extends Behavior
{
    public function validSave(CakeEvent $cakeEvent, EventRecordingInterface $entity)
    {
        $unpublishedEvents = $entity->getUnpublishedEvents();
        foreach ($unpublishedEvents as $event) {
            MessageQueue::get('default')->publish(
                json_encode($event->getPayload()),
                [
                    'application' => MessageQueue::config('default')['exchange'],
                    'type' => Event::type($event),
                    'version' => $event->getVersion(),
                    'content-type' => 'application/json'
                ]
            );
        }
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Model.validSave' => 'validSave'
        ];
    }
}
