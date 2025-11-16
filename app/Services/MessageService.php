<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Message;

class MessageService
{
    public static function create($data)
    {
        return Message::query()->create($data);
    }

    public static function update(Message $message, array $data)
    {
        $message->update($data);
        return $message;
    }

    public static function delete(Message $message)
    {
        $message->delete();
        return $message;
    }

    /*public static function storeMessage(array $data, Chat $chat): Message
    {
        $data = array_merge($data, [ 'chat_id' => $chat->id ]);
        return Message::create($data);
    }*/
}
