<?php

namespace BroadHorizon\EventSourcing\Test\TestCase;

use BroadHorizon\EventSourcing\Payload;
use Cake\TestSuite\TestCase;

class PayloadTest extends TestCase
{
    public function testGetSingleItem()
    {
        $payload = new Payload([
            'key' => 'value1',
        ]);

        $this->assertEquals('value1', $payload->get('key'));
    }

    public function testGetItemFromArray()
    {
        $payload = new Payload([
            'array' => [
                'key' => 'value1',
            ],
        ]);

        $this->assertEquals('value1', $payload->get('array.key'));
    }
}
