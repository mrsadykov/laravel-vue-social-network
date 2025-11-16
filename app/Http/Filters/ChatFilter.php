<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ChatFilter extends AbstractFilter
{
    protected array $keys = [
        'title',
        'profile_id',
        'profile_login'
    ];

    protected function profileLogin(Builder $builder, mixed $value): void
    {
        $builder->whereRelation('profile', 'login', 'ilike', "%$value%");
    }

    protected function title(Builder $builder, mixed $value): void
    {
        $builder->where('title', 'ilike', "%$value%");
    }

    protected function profileId(Builder $builder, mixed $value): void
    {
        $builder->where('profile_id', $value);
    }
}
