<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Servises\WebSocket\Models\WebSocketSwitch;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class WebSocketController extends Controller implements MessageComponentInterface
{
    /**
     * @var \SplObjectStorage
     */
    protected $clients;

    /**
     * @var Collection
     */
    protected Collection $users;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    /**
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    /**
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        $userConnection = $this->users->where("connection_id", "=", $conn->resourceId)->first();
        if ($userConnection) {
            $userConnection["user"]->online = false;
            $userConnection["user"]->save();

            $this->users->where("connection_id", "=", $conn->resourceId)->delete();
        }
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception $e
     * @return void
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "{$e->getMessage()}".PHP_EOL;
    }

    /**
     * @param ConnectionInterface $from
     * @param $msg
     * @return void
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        if (json_decode($msg)->type === WebSocketSwitch::NEW_CONNECTION) {
            $this->addConnection($msg, $from);
        } elseif (json_decode($msg)->type === WebSocketSwitch::SERVER_MESSAGE){
            $this->sendNotification($msg);
        } else {
            WebSocketSwitch::execute($msg);
        }
    }

    /**
     * @param string $message
     * @return void
     */
    private function sendNotification(string $message)
    {
        $messageArr = collect(json_decode($message, true)["message"]['pears'])->pluck("id")->toArray();
        $connections = false;

        if (count($messageArr) >= 2) {
            $connections = $this->users->whereIn("user_id", $messageArr);
        } elseif (count($messageArr) === 1) {
            $connections = $this->users->whereIn("user_id", $messageArr);
        }

        if ($connections && !empty($connections)) {
            foreach ($connections as $connection) {
                $connection["connection"]->send($message);
            }
        }
    }

    /**
     * @param string $message
     * @param ConnectionInterface $conn
     * @return void
     */
    private function addConnection(string $message, ConnectionInterface $conn)
    {
        $message = json_decode($message);

        if (empty($this->users))
        {
            $user = User::find($message->user_id);
            $user->online = true;
            $user->save();

            $this->users = collect([[
                "user" => $user,
                "user_id" => $user->id,
                "connection" => $conn,
                "connection_id" => $conn->resourceId
            ]]);

        } else if (!$this->users->where("user_id", '=', $message->user_id)->first()) {
            $user = User::find($message->user_id);
            $user->online = true;
            $user->save();

            $this->users->push([
                "user" => $user,
                "user_id" => $user->id,
                "connection" => $conn,
                "connection_id" => $conn->resourceId
            ]);
        }
    }
}
