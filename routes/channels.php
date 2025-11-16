<?php

use Illuminate\Support\Facades\Broadcast;

//Broadcast::routes(['middleware' => ['web', 'auth']]);

// подключение к приватному каналу
Broadcast::channel('chats.{chatId}.stored_message', function ($user, $chatId) {
    //return true;
    return $user->profile->chats->contains('id', $chatId);
});

Broadcast::channel('notifications.{profileId}', function ($user, $profileId) {
    return $user->profile->id == $profileId;
});

// дз
// сделать приватными групповые чаты

