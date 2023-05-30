<?php

namespace App\Servises\WebSocket\Interfaces;

interface MessageInterface
{
    /**
     * @param \stdClass $message
     * @return void
     */
    public function run(\stdClass $message);
}
