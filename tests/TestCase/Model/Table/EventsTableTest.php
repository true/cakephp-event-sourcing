<?php

namespace BroadHorizon\EventSourcing\Test\TestCase\Model\Table;

use BroadHorizon\EventSourcing\Model\Table\EventsTable;
use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\TestCase;

class EventsTableTest extends TestCase
{
    public $fixtures = [
        'plugin.broad_horizon/event_sourcing.events',
    ];

    public function testTimestamps()
    {
        $events = new EventsTable([
            'connection' => ConnectionManager::get(EventsTable::defaultConnectionName()),
        ]);
        $events->save($events->newEntity([
            'entity_id' => 'test',
        ]));
    }
}
