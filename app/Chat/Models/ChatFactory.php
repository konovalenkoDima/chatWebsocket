<?php

namespace App\Chat\Models;

use App\Chat\Interfaces\ChatInterface;

class ChatFactory
{
    public const GROUP_CHAT = 1;

    public const PERSONAL_CHAT = 0;

    /**
     * @param string $type
     * @return ChatInterface|void
     */
    public static function getModel(string $type):ChatInterface
    {
        switch ($type){
            case self::GROUP_CHAT: return new GroupChat();
            case self::PERSONAL_CHAT: return new PersonalChat();
        }
    }
}
