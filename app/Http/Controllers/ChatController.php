<?php

namespace App\Http\Controllers;

use App\Chat\DTO\ChatDTO;
use App\Chat\Models\ChatFactory;
use App\Chat\Models\GroupChat;
use App\Models\Dialog;
use App\Models\DialogUser;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Dialog::whereRelation("users", "users.id", "=", Auth::id())->get();

        foreach ($chats as &$chat)
        {
            if (!$chat->group) {
                $secondUser = $chat->users->where("id", "!=", Auth::id())->first();
                $chat->name = $secondUser->name;
            }
        }

        return view('main', [
            "login" => Auth::user()->name,
            "chats" => $chats
        ]);
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function searchUserByName(Request $request): false|string
    {
        return json_encode(User::where("name", "like", "%" . $request->input("username") . "%")->get()->toArray());
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function searchChats(Request $request):false|string
    {
        $chats = Dialog::select("id", "name")->where("name", "like", "%" . $request->input("chatName") . "%")->where("group", true)->get()->toArray();

        $users = User::where("name", "like", "%" . $request->input("chatName") . "%")->where("id", '!=', Auth::id())->get()->toArray();

        return json_encode([
            "users" => $users,
            "chats" => $chats
        ]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function addChat(Request $request): string
    {
        $dto = ChatDTO::fromRequest($request);

        $chat = ChatFactory::getModel($dto->type);

        return $chat->join($dto->itemId);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getChatHistory(Request $request): string
    {
        $messages = Messages::where("dialog_id", $request->input("dialog_id"))->get()->toArray();

        return json_encode([
            "messages" => $messages,
            "currentUser" => Auth::user()->id
        ]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function createGroupChat(Request $request): string
    {
        $chat = new GroupChat();

        $dialog = $chat->create($request->input("chatName"), $request->input("membersIds"));

        return json_encode([
            "name" => $dialog->name,
            "id" => $dialog->id
        ]);
    }
}
