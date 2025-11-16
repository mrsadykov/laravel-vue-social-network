<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

trait HasFilter
{
    public function scopeFilter(Builder $builder, array $data): Builder
    {
        $modelName = class_basename($this);
        $className = 'App\\Http\\Filters\\' . $modelName . 'Filter';

        // filter class not exists
        if (!class_exists($className)) {
            Log::error('Class filter ' . $className . ' for model ' . $modelName .' not exists');
            return $builder;
        }

        $filter = new $className();
        return $filter->apply($builder, $data);
    }
}
