<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        return view('main', [
            "login" => Auth::user()->name,
            "chats" => collect([
                [
                    "name" => "Test Chat",
                    "lastMessage" => "Hello!"
                ]
            ])
        ]);
    }
}
