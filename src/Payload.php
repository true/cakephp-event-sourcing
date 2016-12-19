<?php

namespace BroadHorizon\EventSourcing;

use Cake\Utility\Hash;

class Payload
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get(string $name)
    {
        return Hash::get($this->data, $name);
    }
}
