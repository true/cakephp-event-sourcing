<?php

namespace BroadHorizon\EventSourcing\Test\TestCase\Handler\Locator;

use App\Command\AbstractCommand;
use App\Command\TestCommand;
use BroadHorizon\EventSourcing\Handler\Locator\InMemoryInstanceOfLocator;
use Cake\TestSuite\TestCase;

class InMemoryInstanceOfLocatorTest extends TestCase
{
    public function testEmptyConstructor()
    {
        new InMemoryInstanceOfLocator([]);
    }

    public function testConstructor()
    {
        $handler = new class {};
        $locator = new InMemoryInstanceOfLocator([
            AbstractCommand::class => $handler,
        ]);

        $this->assertSame($handler, $locator->getHandlerForCommand(TestCommand::class));
    }

    /**
     * @expectedException \League\Tactician\Exception\MissingHandlerException
     * @expectedExceptionMessage Missing handler for command test
     */
    public function testMissingHandler()
    {
        $locator = new InMemoryInstanceOfLocator([]);
        $locator->getHandlerForCommand('test');
    }

    public function testAddHandler()
    {
        $locator = new InMemoryInstanceOfLocator([]);
        $handler = new class {};
        $locator->addHandler($handler, AbstractCommand::class);

        $this->assertSame($handler, $locator->getHandlerForCommand(TestCommand::class));
    }
}
