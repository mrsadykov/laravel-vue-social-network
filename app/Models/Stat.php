<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = [
        'posts_count',
        'comments_count',
        'likes_count',
        'posts_views_count',
        'likes_to_posts_views',
        'likes_to_comments'
    ];

    protected $casts = [
        'likes_to_posts_views' => 'decimal:2',
        'likes_to_comments' => 'decimal:2',
        'created_at' => 'datetime: d.m.Y H:i:s'
    ];
}
