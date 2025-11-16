<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        return CommentResource::collection(Comment::all())->resolve();
    }

    public function show(Comment $comment)
    {
        return CommentResource::make($comment)->resolve();
    }

    public function store()
    {
        $data = [
            'author' => 'Iskandar',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel nulla orci. In vehicula imperdiet sodales. Etiam vel rhoncus quam, sed maximus erat. Maecenas viverra ultricies justo, eu euismod velit lacinia sed. Quisque id efficitur libero. Ut interdum lectus molestie finibus imperdiet. Praesent vel ante sed diam mattis vehicula. Aenean pellentesque eros sit amet sem laoreet, ut egestas ante venenatis. Nullam et enim nunc. Nunc efficitur nulla ac enim iaculis ornare. Proin rutrum ante sed lectus suscipit vulputate. Morbi vel mattis tortor, in eleifend ante. Vestibulum ornare magna lorem, sed vestibulum nisi eleifend eget. In accumsan sapien purus, rhoncus dapibus.',
            'published_at' => date('d.m.Y H:i'),
            'post' => '77'
        ];

        $comment = Comment::query()->create($data);
        return CommentResource::make($comment)->resolve();
    }

    public function update(Comment $comment)
    {
        $data = [
            'author' => 'Iskandar edited ' . md5(now()),
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel nulla orci. In vehicula imperdiet sodales. Etiam vel rhoncus quam, sed maximus erat. Maecenas viverra ultricies justo, eu euismod velit lacinia sed. Quisque id efficitur libero. Ut interdum lectus molestie finibus imperdiet. Praesent vel ante sed diam mattis vehicula. Aenean pellentesque eros sit amet sem laoreet, ut egestas ante venenatis. Nullam et enim nunc. Nunc efficitur nulla ac enim iaculis ornare. Proin rutrum ante sed lectus suscipit vulputate. Morbi vel mattis tortor, in eleifend ante. Vestibulum ornare magna lorem, sed vestibulum nisi eleifend eget. In accumsan sapien purus, rhoncus dapibus.',
            'published_at' => date('d.m.Y H:i'),
            'post' => '77'
        ];

        $comment->update($data);
        return CommentResource::make($comment)->resolve();
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response([
            'message' => 'Comment deleted'
        ]);
    }
}
