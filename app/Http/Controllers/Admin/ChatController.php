<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatResource;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::all();
        $chats = ChatResource::collection($chats)->resolve();
        return inertia('Admin/Chat/Index', compact('chats'));
    }

    public function show(Chat $chat)
    {
        $login = $chat?->profile?->login;
        $chat = ChatResource::make($chat)->resolve();
        return inertia('Admin/Chat/Show', compact('chat', 'login'));
    }
}
