<?php

namespace App\Http\Controller;

use App\Http\Requests\Api\Chat\StoreRequest;
use App\Http\Resources\Chat\ChatResource;
use App\Models\Chat;

class ChatController extends Controller
{
    public function index()
    {
        return ChatResource::collection(Chat::all())->resolve();
    }

    public function show(Chat $chat)
    {
        return ChatResource::make($chat)->resolve();
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $chat = Chat::query()->create($data);
        return ChatResource::make($chat)->resolve();
    }

    public function update(Chat $chat)
    {
        $data = [
            'title' => 'some chat ' . md5(now())
        ];

        $chat->update($data);
        return ChatResource::make($chat)->resolve();
    }

    public function destroy(Chat $chat)
    {
        $chat->delete();
        return response([
            'message' => 'Chat deleted'
        ]);
    }
}
