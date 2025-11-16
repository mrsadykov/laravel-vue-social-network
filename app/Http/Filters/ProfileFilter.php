<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProfileFilter extends AbstractFilter
{
    protected array $keys = [
        'second_name',
        'third_name',
        'city',
        'login',
        'user_id',
        'post_id',
        'chat_id'
    ];

    protected function postId(Builder $builder, mixed $value)
    {
        $builder->whereRelation('posts', 'id', $value);
    }

    protected function chatId(Builder $builder, mixed $value)
    {
        $builder->whereRelation('chats', 'id', $value);
    }

    protected function userId(Builder $builder, mixed $value)
    {
        $builder->where('user_id', $value);
    }

    protected function secondName(Builder $builder, mixed $value): void
    {
        $builder->where('second_name', 'ilike', "%$value%");
    }

    protected function thirdName(Builder $builder, mixed $value): void
    {
        $builder->where('third_name', 'ilike', "%$value%");
    }

    protected function city(Builder $builder, mixed $value): void
    {
        $builder->where('city', 'ilike', "%$value%");
    }

    protected function login(Builder $builder, mixed $value): void
    {
        $builder->where('login', 'ilike', "%$value%");
    }
}
