<?php

namespace BroadHorizon\EventSourcing\Test\TestCase\Console;

use BroadHorizon\EventSourcing\Console\ShellDispatcher;
use Cake\TestSuite\TestCase;
use League\Tactician\CommandBus;

class ShellDispatcherTest extends TestCase
{
    /**
     * @expectedException \TypeError
     * @expectedExceptionMessage Return value of App\Shell\TestShell::getCommandBus() must be an instance of League\Tactician\CommandBus, null returned
     */
    public function testNonCommandBusAwareShell()
    {
        $commandBus = new CommandBus([]);

        $shellDispatcher = new ShellDispatcher($commandBus);

        $shellDispatcher->runWithCommandBus(
            $commandBus,
            ['bin/cake', 'test', '-q']
        );
    }

    public function testCommandBusAwareShell()
    {
        $commandBus = new CommandBus([]);

        $shellDispatcher = new ShellDispatcher($commandBus);

        $errorCode = $shellDispatcher->runWithCommandBus(
            $commandBus,
            ['bin/cake', 'command_bus_aware', '-q']
        );
        $this->assertEquals(0, $errorCode);
    }
}
