<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class TagFilter extends AbstractFilter
{
    protected array $keys = [
        'title',
        'post_id',
        'post_title'
    ];

    protected function title(Builder $builder, mixed $value)
    {
        $builder->where('title', 'ilike', "%$value%");
    }

    protected function postId(Builder $builder, mixed $value)
    {
        $builder->whereRelation('posts', 'post_id', $value);
    }

    protected function postTitle(Builder $builder, mixed $value)
    {
        $builder->whereRelation('posts', 'title', 'ilike', "%$value%");
    }
}
