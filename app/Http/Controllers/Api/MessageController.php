<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Message\IndexRequest;
use App\Http\Requests\Api\Message\StoreRequest;
use App\Http\Requests\Api\Message\UpdateRequest;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        $messages = Message::filter($data)->get();
        return MessageResource::make($messages)->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $message = MessageService::create($data);
        return MessageResource::make($message)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        return MessageResource::make($message)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Message $message)
    {
        $data = $request->validated();
        $message = MessageService::update($message, $data);
        return MessageResource::make($message)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        MessageService::delete($message);
        return response()->json([
            'message' => 'Message deleted'
        ], Response::HTTP_OK);
    }
}
