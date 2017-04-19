<?php

namespace BroadHorizon\EventSourcing\Model\Table;

use Cake\Database\Schema\TableSchema;
use Cake\ORM\Table;

class EventsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Timestamp');
    }

    protected function _initializeSchema(TableSchema $schema)
    {
        $schema->columnType('payload', 'json');

        return $schema;
    }
}
