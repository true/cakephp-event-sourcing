<?php

namespace App\Shell;

use BroadHorizon\EventSourcing\CommandBusAwareInterface;
use BroadHorizon\EventSourcing\CommandBusAwareTrait;
use Cake\Console\Shell;

class CommandBusAwareShell extends Shell implements CommandBusAwareInterface
{
    use CommandBusAwareTrait;

    public function main()
    {
    }
}
