<?php

namespace App\Http\Controllers\Client;

use App\Events\WS\Message\SendMessageEvent;
use App\Models\Chat;
use App\Models\Message;
use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Requests\Client\Chat\StoreRequest;
use App\Http\Requests\Client\Chat\StoreMessageRequest;
use App\Http\Resources\Message\MessageResource;
use App\Http\Resources\Profile\ProfileResource;
use App\Models\Profile;
use App\Services\ChatService;
use App\Services\MessageService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $chatId = ChatService::firstOrCreate($data);
        return redirect()->route('client.chats.show', $chatId);
    }

    public function show(Chat $chat)
    {
        $messages = MessageResource::collection($chat->messages)->resolve();
        $profiles = ProfileResource::collection($chat->profiles)->resolve();
        $chat = ChatResource::make($chat)->resolve();

        return inertia('Client/Chat/Show', compact('chat', 'messages', 'profiles'));
    }

    public function getMessages(Chat $chat)
    {
        return MessageResource::collection($chat->messages()->with([
            'chat',
            'profile'
        ])->get())->resolve();
    }

    public function index()
    {
        $chats = auth()->user()->profile->chats()->with([
            'messages',
            'profiles'
        ])->get();

        $chats = ChatResource::collection($chats)->resolve();

        $profiles = ProfileResource::collection(Profile::query()->with([
            'user',
            'notifications',
            'followers',
            'followings',
            'viewedPosts',
            'image',
            'likedPosts',
            'likedComments',
            'chats'
        ])->get())->resolve();

        return inertia('Client/Chat/Index', compact('chats', 'profiles'));
    }

    public function storeMessage(Chat $chat, StoreMessageRequest $request)
    {
        $data = $request->validated();
        //dd($data);

        //$message = MessageService::storeMessage($data, $chat);
        $message = $chat->messages()->create($data);
        $message = MessageResource::make($message)->resolve();

        //SendMessageEvent::dispatch($message);
        SendMessageEvent::broadcast($message)->toOthers();

        return $message;
    }
}
