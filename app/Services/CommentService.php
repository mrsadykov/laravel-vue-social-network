<?php

namespace App\Services;

use App\Models\Comment;

class CommentService
{
    public static function create($data)
    {
        return Comment::query()->create($data);
    }

    public static function update(Comment $comment, array $data)
    {
        $comment->update($data);
        return $comment;
    }

    public static function delete(Comment $comment)
    {
        $comment->delete();
        return $comment;
    }
}
