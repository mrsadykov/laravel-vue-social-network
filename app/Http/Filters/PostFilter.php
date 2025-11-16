<?php

namespace App\Http\Filters;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class PostFilter extends AbstractFilter
{
    protected array $keys = [
        'title',
        'content',
        'views_from',
        'published_at_from',
        'category_id',
        'profile_id',
        'category_title',
    ];

    protected function categoryTitle(Builder $builder, mixed $value): void
    {
        // category - отношение в модели Post
        $builder->whereRelation('category', 'title', 'ilike', "%$value%");
    }

    protected function viewsFrom(Builder $builder, mixed $value): void
    {
        $builder->whereHas('viewedByProfiles', function ($query) use ($value) {
            $query->select(DB::raw('count(*)'))
                ->groupBy('viewable_id')
                ->havingRaw('count(*) >= ?', [ $value ]);
        });
    }

    protected function title(Builder $builder, mixed $value): void
    {
        $builder->where('title', 'ilike', "%$value%");
    }

    protected function content(Builder $builder, mixed $value): void
    {
        $builder->where('content', 'ilike', "%$value%");
    }

    protected function publishedAtFrom(Builder $builder, mixed $value): void
    {
        $builder->where('published_at', '>', $value);
    }

    protected function profileId(Builder $builder, mixed $value): void
    {
        $builder->where('profile_id', $value);
    }

    protected function categoryId(Builder $builder, mixed $value): void
    {
        $builder->where('category_id', $value);
    }
}
