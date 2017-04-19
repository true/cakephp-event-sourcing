<?php

namespace App\Controller;

use BroadHorizon\EventSourcing\CommandBusAwareTrait;
use Cake\Controller\Controller;

class TestController extends Controller
{
    use CommandBusAwareTrait;
}
