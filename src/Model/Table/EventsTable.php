<?php

namespace BroadHorizon\EventSourcing\Model\Table;

use Cake\ORM\Table;

class EventsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
    }
}
