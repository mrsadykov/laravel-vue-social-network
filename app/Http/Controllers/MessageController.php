<?php

namespace App\Http\Controllers;

use App\Http\Resources\Message\MessageResource;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        return MessageResource::collection(Message::all())->resolve();
    }

    public function show(Message $message)
    {
        return MessageResource::make($message)->resolve();
    }

    public function store()
    {
        $data = [
            'content' => 'some message',
            'author' => 'Iskandar',
            'chat' => 11,
            'published_at' => date('Y-m-d H:i:s')
        ];

        $message = Message::query()->create($data);
        return MessageResource::make($message)->resolve();
    }

    public function update(Message $message)
    {
        $data = [
            'content' => 'some message edited ' . md5(now()),
            'author' => 'Iskandar',
            'chat' => 12,
            'published_at' => date('Y-m-d H:i:s')
        ];

        $message->update($data);
        return MessageResource::make($message)->resolve();
    }

    public function destroy(Message $message)
    {
        $comment->delete();
        return response([
            'message' => 'Message deleted'
        ]);
    }
}
