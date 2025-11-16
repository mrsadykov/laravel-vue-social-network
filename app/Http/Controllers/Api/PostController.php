<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Http\Requests\Api\Post\IndexRequest;
use App\Http\Requests\Api\Post\StoreRequest;
use App\Http\Requests\Api\Post\UpdateRequest;

class PostController extends Controller
{
    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        $posts = Post::filter($data)->get();

        return PostResource::collection($posts)->resolve();
    }

    // Post $post
    public function show(Post $post)
    {
        // $post = Post::query()->find(9999);
        //$post = Post::query()->find(1);

        // PostException::ifPostNotExists($post);
        // может понадобиться где-то после validate
        //PostException::ifPostExists($post);

        return PostResource::make($post)->resolve();
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        // Использование сервиса для бизнес-логики
        $post = PostService::create($data);
        return PostResource::make($post)->resolve();
    }

    public function update(UpdateRequest $request, Post $post)
    {
        $data = $request->validated();
        $post = PostService::update($post, $data);
        return PostResource::make($post)->resolve();
    }

    public function destroy(Post $post)
    {
        PostService::delete($post);
        return response()->json([
            'message' => 'Post deleted'
        ], Response::HTTP_OK);
    }
}
