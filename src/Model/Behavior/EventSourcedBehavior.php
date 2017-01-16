<?php

namespace BroadHorizon\EventSourcing\Model\Behavior;

use BroadHorizon\EventSourcing\Event;
use BroadHorizon\EventSourcing\Model\EventRecordingInterface;
use Cake\Core\App;
use Cake\Event\Event as CakeEvent;
use Cake\Log\Log;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Cake\ORM\TableRegistry;

class EventSourcedBehavior extends Behavior
{
    public function beforeFind(CakeEvent $cakeEvent, Query $query)
    {
        return $query->formatResults(function (ResultSet $resultSet) {
            $events = TableRegistry::get('BroadHorizon/EventSourcing.Events');

            return $resultSet->map(function (Entity $entity) use ($events) {
                $entity->events = $events
                    ->find()
                    ->where([
                        'entity_id' => $entity->get('id')
                    ])
                    ->toList();

                return $entity;
            });
        });
    }

    public function beforeSave(CakeEvent $cakeEvent, EventRecordingInterface $entity)
    {

    }

    public function validSave(CakeEvent $cakeEvent, EventRecordingInterface $entity, array $settings)
    {
        $events = TableRegistry::get('BroadHorizon/EventSourcing.Events');
        $entityName = App::shortName(get_class($entity), 'Model/Entity');

        $unpublishedEvents = $entity->getUnpublishedEvents();
        foreach ($unpublishedEvents as $event) {
            $eventName = substr(App::shortName(get_class($event), 'Model/Event'), strlen($entityName) + 1);
            $this->_table->dispatchEvent(
                'Model.' . $eventName,
                compact('entity', 'event', 'settings')
            );

            $eventEntity = $events->newEntity([
                'entity_id' => $entity->id,
                'type' => Event::type($event),
                'payload' => json_encode($event->toPayload()),
            ]);

            $events->save($eventEntity);
        }
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Model.validSave' => 'validSave'
        ];
    }
}
