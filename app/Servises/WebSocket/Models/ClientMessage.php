<?php

namespace App\Servises\WebSocket\Models;

use App\Models\Messages;
use App\Servises\WebSocket\Interfaces\MessageInterface;

class ClientMessage implements MessageInterface
{
    /**
     * @param \stdClass $message
     * @return void
     */
    public function run(\stdClass $message)
    {
        $attributes = [
            "message" => $message->message,
            "sender" => $message->sender,
            "dialog_id" => $message->pear
        ];

        $message = new Messages($attributes);
        $message->save();

        WebSocketSwitch::execute(json_encode([
            "type" => WebSocketSwitch::SERVER_MESSAGE,
            "message" => $attributes
        ]));
    }
}
