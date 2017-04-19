<?php

namespace App\Controller;

use BroadHorizon\EventSourcing\CommandBusAwareInterface;
use BroadHorizon\EventSourcing\CommandBusAwareTrait;
use Cake\Controller\Controller;

class CommandBusAwareController extends Controller implements CommandBusAwareInterface
{
    use CommandBusAwareTrait;
}
