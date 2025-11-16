<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasLog
{
    // trait HasLogStorage -> bootHasStorageLog
    protected static function bootHasLog() //bootHasLog
    {
        static::created(function(Model $model) {
            //LogService::create('created', $model); - задание с 8 урока
            logModelChange('created', $model);
        });

        static::updated(function(Model $model) {
            //LogService::create('updated', $model);
            logModelChange('updated', $model);
            //dd($model->getDirty());
        });

        static::deleted(function(Model $model) {
            //LogService::create('deleted', $model);
            logModelChange('deleted', $model);
        });

        static::retrieved(function(Model $model) {
            //LogService::create('retrieved', $model);
            logModelChange('retrieved', $model);
        });
    }
}
