<?php

namespace App\Servises\Websocket\DTO;

class WebSocketDto
{
    public $messageType;

    public $message;

    public static function fromJson($json)
    {
        $request = json_decode($json, 1);
        $self = new WebSocketDto();
        $self->message = $request['message'];
        $self->messageType = $request['$message_type'];
        return $self;
    }
}
