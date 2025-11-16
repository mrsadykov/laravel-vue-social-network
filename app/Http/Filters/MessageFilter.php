<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class MessageFilter extends AbstractFilter
{
    protected array $keys = [
        'content',
        'published_at_from',
        'published_at_to',
        'chat_id',
        'chat_title',
        'profile_id',
        'profile_login'
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

    protected function chatId(Builder $builder, mixed $mixed): void
    {
        $builder->where('chat_id', $mixed);
    }

    protected function chatTitle(Builder $builder, mixed $mixed): void
    {
        $builder->whereRelation('chat', 'title', 'ilike', "%$mixed%");
    }

    protected function profileId(Builder $builder, mixed $mixed): void
    {
        $builder->where('profile_id', $mixed);
    }

    protected function profileLogin(Builder $builder, mixed $mixed): void
    {
        $builder->whereRelation('profile', 'login', 'ilike', "%$mixed%");
    }
}
