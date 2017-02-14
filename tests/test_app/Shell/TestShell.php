<?php

namespace App\Shell;

use BroadHorizon\EventSourcing\CommandBusAwareTrait;
use Cake\Console\Shell;

class TestShell extends Shell
{
    use CommandBusAwareTrait;

    public function main()
    {
        $this->getCommandBus();
    }
}
