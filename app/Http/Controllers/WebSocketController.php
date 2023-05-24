<?php

namespace App\Http\Controllers;

use App\Servises\Websocket\DTO\WebSocketDto;
use App\Servises\Websocket\Models\WebSocketSwitch;
use Illuminate\Support\Facades\Log;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class WebSocketController extends Controller implements MessageComponentInterface
{
    protected $clients;

    protected $chanels;

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        Log::error("An error has occurred: {$e->getMessage()}");
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $dto = WebSocketDto::fromJson($msg);

        (WebSocketSwitch::execute($dto->messageType))->run($dto->message);
    }
}
