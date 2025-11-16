<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CommentFilter extends AbstractFilter
{
    protected array $keys = [
        'content',
        'published_at_from',
        'published_at_to',
        'profile_id',
        'profile_login',
        'post_id',
        'post_title'
    ];

    protected function content(Builder $builder, mixed $mixed): void
    {
        $builder->where('content', 'ilike', "%$mixed%");
    }

    protected function publishedAtFrom(Builder $builder, mixed $mixed): void
    {
        $builder->where('published_at', '>=', $mixed);
    }

    protected function publishedAtTo(Builder $builder, mixed $mixed): void
    {
        $builder->where('published_at', '<=', $mixed);
    }

    protected function profileId(Builder $builder, mixed $mixed): void
    {
        $builder->where('profile_id', $mixed);
    }

    protected function profileLogin(Builder $builder, mixed $mixed): void
    {
        $builder->whereRelation('profile', 'login', 'ilike', "%$mixed%");
    }

    protected function postId(Builder $builder, mixed $mixed): void
    {
        $builder->where('post_id', $mixed);
    }

    protected function postTitle(Builder $builder, mixed $mixed): void
    {
        $builder->whereRelation('post', 'title', 'ilike', "%$mixed%");
    }
}
