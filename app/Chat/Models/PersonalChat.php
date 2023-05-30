<?php

namespace App\Chat\Models;

use App\Models\Dialog;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PersonalChat extends BaseChat implements \App\Chat\Interfaces\ChatInterface
{
    /**
     * @param int $itemId
     * @return false|string
     */
    public function join(int $itemId)
    {
        $firstUser = Auth::user();

        $secondUser = User::find($itemId);

        $existDialog = Dialog::with(["users" => function($query) use ($firstUser, $secondUser) {
                $query->where("users.id", $firstUser->id)->orWhere("users.id", $secondUser->id)->get();
            }])
            ->first();

        if (!empty($existDialog)) {
            return json_encode([
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "Chat exist"
            ]);
        }

        $chat = new Dialog();
        $chat->name = "Private";
        $chat->group = ChatFactory::PERSONAL_CHAT;
        $chat->save();

        $this->addMembers([
            $itemId,
            Auth::user()->id
        ], $chat->id);

        return json_encode([
            "status" => Response::HTTP_OK,
            "chatName" => $secondUser->name
        ]);
    }
}
