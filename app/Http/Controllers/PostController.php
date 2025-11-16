<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Post\IndexRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    public function index(IndexRequest $request)
    {
        return PostResource::collection(Post::all())->resolve();
    }

    public function show(Post $post)
    {
        return PostResource::make($post)->resolve();
    }

    public function store()
    {
        $data = [
            'title' => 'Lorem ipsum ' . md5(now()),
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod, diam quis semper blandit, ipsum massa accumsan velit, ut efficitur nisl arcu ac lectus. Ut ornare lacus sed malesuada dictum.'
        ];

        $post = Post::query()->create($data);
        return PostResource::make($post)->resolve();
    }

    public function update(Post $post)
    {
        $data = [
            'title' => 'Edited Lorem ipsum edited ' . md5(now()),
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod, diam quis semper blandit, ipsum massa accumsan velit, ut efficitur nisl arcu ac lectus. Ut ornare lacus sed malesuada dictum.'
        ];

        $post = $post->update($data);
        return PostResource::make($post)->resolve();
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response([
            'message' => 'Post deleted'
        ]);
    }
}
