<?php

namespace App\Servises\WebSocket\Models;

use App\Models\User;
use App\Servises\WebSocket\Interfaces\MessageInterface;
use WebSocket\Client;

class ServerMessage implements MessageInterface
{

    /**
     * @param \stdClass $message
     * @return void
     */
    public function run(\stdClass $message)
    {
        $chatMembers = User::select("id")->whereRelation("dialogs", "dialogs.id", "=", $message->dialog_id)->where("online", true)->get()->toArray();

        \App\Jobs\ServerMessage::dispatch($message, $chatMembers);
    }
}
