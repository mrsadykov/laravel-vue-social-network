<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Chat\IndexRequest;
use App\Http\Requests\Api\Chat\StoreRequest;
use App\Http\Requests\Api\Chat\UpdateRequest;
use App\Http\Resources\Chat\ChatResource;
use App\Models\Chat;
use App\Services\ChatService;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        //dd($data);
        $chats = Chat::filter($data)->get();
        return ChatResource::make($chats)->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $chat = ChatService::create($data);
        return ChatResource::make($chat)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        return ChatResource::make($chat)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Chat $chat)
    {
        $data = $request->validated();
        $chat = ChatService::update($chat, $data);
        return ChatResource::make($chat)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        ChatService::delete($chat);
        return response()->json([
            'message' => 'Chat deleted'
        ], Response::HTTP_OK);
    }
}
