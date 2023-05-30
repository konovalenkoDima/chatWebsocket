<?php

namespace App\Jobs;

use App\Servises\WebSocket\Models\WebSocketSwitch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use WebSocket\Client;

class ServerMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $message;

    public $members;

    /**
     * Create a new job instance.
     */
    public function __construct($message, $members)
    {
        $this->message = $message;
        $this->members = $members;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client("ws://127.0.0.1:8080");
        $client->text(json_encode([
            "type" => WebSocketSwitch::SERVER_MESSAGE,
            "message" => [
                "pears" => $this->members,
                "sender" => $this->message->sender,
                "dialog_id" => $this->message->dialog_id,
                "message" => $this->message->message,
            ]
        ]));
        $client->close();
    }
}
