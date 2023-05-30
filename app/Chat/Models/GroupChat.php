<?php

namespace App\Chat\Models;

use App\Models\Dialog;
use Illuminate\Support\Facades\Auth;

class GroupChat extends BaseChat implements \App\Chat\Interfaces\ChatInterface
{
    /**
     * @param int $itemId
     * @return mixed
     */
    public function join(int $itemId)
    {
        $this->addMembers([Auth::user()->id], $itemId);

        return Dialog::find($itemId)->name;
    }

    /**
     * @param string $name
     * @param array $membersIds
     * @return Dialog
     */
    public function create(string $name, array $membersIds)
    {
        $dialog = new Dialog();
        $dialog->name = $name;
        $dialog->group = 1;
        $dialog->save();
        $this->addMembers(array_merge($membersIds, [Auth::id()]), $dialog->id);

        return $dialog;
    }
}
