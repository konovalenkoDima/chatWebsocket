<?php

namespace App\Servises\Websocket\Models;

class WebSocketSwitch
{
    const SERVER_MESSAGE = "FromServer";

    const CLIENT_MESSAGE = "FromClient";

    public static function execute($messageType)
    {
        switch ($messageType){
            case self::SERVER_MESSAGE: return new ServerMessage();
            case self::CLIENT_MESSAGE: return new ChatController();
        }
    }
}
