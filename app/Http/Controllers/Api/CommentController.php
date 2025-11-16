<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comment\IndexRequest;
use App\Http\Requests\Api\Comment\StoreRequest;
use App\Http\Requests\Api\Comment\UpdateRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        $comments = Comment::filter($data)->get();
        return CommentResource::make($comments)->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $comment = CommentService::create($data);
        return CommentResource::make($comment)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return CommentResource::make($comment)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Comment $comment)
    {
        $data = $request->validated();
        $comment = CommentService::update($comment, $data);
        return CommentResource::make($comment)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        CommentService::delete($comment);
        return response()->json([
            'message' => 'Comment deleted'
        ], Response::HTTP_OK);
    }
}
