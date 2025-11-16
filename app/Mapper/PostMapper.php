<?php

namespace App\Mapper;

use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostMapper
{
    public static function show(Post $post): array
    {
        // с пагинацией
        // параметры по умолчанию
        $data = [
            'per_page' => 10,
            'page' => 1
        ];

        // Создаем уникальный ключ, включающий ID поста, номер страницы и количество элементов на странице
        $key = "comments_post_{$post->id}_page_{$data['page']}_per_page_{$data['per_page']}";

        $comments = Cache::get($key);

        if (!$comments) {
            $comments = $post
                ->comments()
                ->latest()
                ->where('parent_comment_id', null)
                ->paginate(
                    $data['per_page'],
                    '*',
                    'page',
                    $data['page']
                );

            Cache::put($key, $comments, now()->addMinutes(120));
        }

        $comments = CommentResource::collection($comments);

        // без пагинации
        // $comments = CommentResource::collection($post->comments)->resolve();

        $post = PostResource::make($post)->resolve();

        return [
            'post' => $post,
            'comments' => $comments
        ];
    }
}
