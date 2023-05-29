<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "group"
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, "dialog_user", "dialog_id", "user_id");
    }

    public function messages()
    {
        return $this->hasMany(Messages::class, "dialog_id");
    }

    public function lastMessage()
    {
        return $this->hasOne(Messages::class, "dialog_id")->latest();
    }
}
