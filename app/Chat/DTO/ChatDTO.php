<?php

namespace App\Chat\DTO;

use App\Chat\Models\ChatFactory;
use Illuminate\Http\Request;

class ChatDTO
{
    public int $itemId;

    public int $type;

    public static function fromRequest(Request $request)
    {
        $dto = new self();
        $dto->itemId = $request->input("id");
        switch ($request->input("type")){
            case "user": $dto->type = ChatFactory::PERSONAL_CHAT;break;
            case "group": $dto->type = ChatFactory::GROUP_CHAT;break;
        }

        return $dto;
    }
}
