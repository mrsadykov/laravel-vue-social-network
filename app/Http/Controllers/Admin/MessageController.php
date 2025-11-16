<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        $messages = MessageResource::collection($messages)->resolve();
        return inertia('Admin/Message/Index', compact('messages'));
    }

    public function show(Message $message)
    {
        $chatTitle = $message->chat->title;
        $profileLogin = $message->profile->login;
        $message = MessageResource::make($message)->resolve();

        return inertia('Admin/Message/Show', compact('message', 'chatTitle', 'profileLogin'));
    }
}
