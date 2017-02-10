<?php

namespace BroadHorizon\EventSourcing\Shell;

use BroadHorizon\EventSourcing\MessageQueue;
use Cake\Console\Shell;

class EventShell extends Shell
{
    public function initialize()
    {
        parent::initialize();

        $this->loadModel('BroadHorizon/EventSourcing.Events');
    }

    public function getOptionParser()
    {
        $consoleOptionParser = parent::getOptionParser();
        $consoleOptionParser->addSubcommand('requeue', [
            'help' => 'Requeue all stored events',
        ]);

        return $consoleOptionParser;
    }

    public function requeue()
    {
        debug($this->Events->find()->toArray());

        debug(MessageQueue::get('default'));

        exit();
    }
}
