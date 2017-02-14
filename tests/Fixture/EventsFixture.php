<?php

namespace BroadHorizon\EventSourcing\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class EventsFixture extends TestFixture
{
    public $fields = [
        'id' => [
            'type' => 'uuid',
        ],
        'entity_id' => [
            'type' => 'uuid',
        ],
        'version' => [
            'type' => 'integer',
        ],
        'type' => [
            'type' => 'text',
        ],
        'payload' => [
            'type' => 'text',
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ],
    ];

    public $records = [

    ];
}
