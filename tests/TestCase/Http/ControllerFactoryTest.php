<?php

namespace BroadHorizon\EventSourcing\Test\TestCase\Http;

use App\Controller\CommandBusAwareController;
use App\Controller\TestController;
use BroadHorizon\EventSourcing\Http\ControllerFactory;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use League\Tactician\CommandBus;
use Zend\Diactoros\Uri;

class ControllerFactoryTest extends TestCase
{
    /**
     * @expectedException \TypeError
     * @expectedExceptionMessage Return value of App\Controller\TestController::getCommandBus() must be an instance of League\Tactician\CommandBus, null returned
     */
    public function testNonCommandBusAwareController()
    {
        $controllerFactory = new ControllerFactory(new CommandBus([]));

        $request = new ServerRequest([
            'url' => '/',
            'uri' => new Uri('/'),
            'params' => [
                'controller' => 'Test'
            ],
        ]);
        $response = new Response();
        $controller = $controllerFactory->create($request, $response);
        $this->assertInstanceOf(TestController::class, $controller);

        $controller->getCommandBus();
    }

    public function testCommandBusAwareController()
    {
        $commandBus = new CommandBus([]);
        $controllerFactory = new ControllerFactory($commandBus);

        $request = new ServerRequest([
            'url' => '/',
            'uri' => new Uri('/'),
            'params' => [
                'controller' => 'CommandBusAware'
            ],
        ]);
        $response = new Response();
        $controller = $controllerFactory->create($request, $response);
        $this->assertInstanceOf(CommandBusAwareController::class, $controller);
        $this->assertSame($commandBus, $controller->getCommandBus());
    }
}
