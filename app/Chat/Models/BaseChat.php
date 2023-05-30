<?php

namespace App\Chat\Models;

use App\Models\DialogUser;
use Illuminate\Support\Facades\DB;

class BaseChat
{
    /**
     * @param array $membersIds
     * @param int $dialogId
     * @return void
     */
    protected function addMembers(array $membersIds, int $dialogId)
    {
        DB::transaction(function () use ($membersIds, $dialogId){
            foreach ($membersIds as $id)
            {
                $dialogUser = new DialogUser();
                $dialogUser->user_id = $id;
                $dialogUser->dialog_id = $dialogId;
                $dialogUser->save();
            }
        });
    }
}
