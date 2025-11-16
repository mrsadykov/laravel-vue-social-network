<?php

namespace App\Http\Filters;

use Illuminate\Support\Str;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

abstract class AbstractFilter
{
    protected array $keys = [];

    public function apply(Builder $builder, array $data): Builder
    {
        foreach ($this->keys as $key) {
            if (isset($data[$key]) && !empty($data[$key])) {
                $methodName = Str::camel($key);
                $className = get_class($this);

                // method not exists
                if (!method_exists($className, $methodName)) {
                    Log::error('Method ' . $methodName . ' in class ' . $className . ' not exists');
                    continue;
                }

                $this->$methodName($builder, $data[$key]);
            }
        }

        return $builder;
    }
}
