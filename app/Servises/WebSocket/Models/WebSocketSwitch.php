<?php

namespace App\Servises\WebSocket\Models;

use WebSocket\Client;

class WebSocketSwitch
{
    const NEW_CONNECTION = "NewConnection";

    const SERVER_MESSAGE = "FromServer";

    const CLIENT_MESSAGE = "FromClient";

    /**
     * @param string $message
     * @return void
     */
    public static function execute(string $message)
    {
        $message = json_decode($message);

        switch ($message->type){
            case self::SERVER_MESSAGE: $service = new ServerMessage();break;
            case self::CLIENT_MESSAGE: $service = new ClientMessage();break;
        }

        $service->run($message->message);
    }
}
