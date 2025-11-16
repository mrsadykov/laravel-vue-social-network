<?php

namespace App\Services;

use App\Models\Chat;

class ChatService
{
    public static function create(array $data): Chat
    {
        return Chat::query()->create($data);
    }

    public static function firstOrCreate(array $data): int
    {
        $chatId = Chat::findChatByProfiles($data['profile_ids']);
        if (!$chatId) {
            // Если чата с указанным пользователем не существует
            // те в чате должны быть только текущий пользователь и те кто в $data['profile_ids']
            $chat = Chat::create();
            $chat->profiles()->attach($data['profile_ids']);
            $chatId = $chat->id;
        }
        return $chatId;
    }

    public static function update(Chat $chat, array $data)
    {
        $chat->update($data);
        return $chat;
    }

    public static function delete(Chat $chat)
    {
        $chat->delete();
        return $chat;
    }
}
