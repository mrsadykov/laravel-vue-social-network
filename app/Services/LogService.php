<?php

namespace App\Services;

use App\Models\Log;
use App\Events\Log\AfterStoredLogEvent;
use App\Events\Log\BeforeStoredLogEvent;
use Illuminate\Database\Eloquent\Model;

class LogService
{
    public static function create(string $functionName, Model $model)
    {
        // Первое кастомное событие
        //BeforeStoredLogEvent::dispatch();

        $log = Log::query()->create([
            'event' => $functionName,
            'model' => get_class($model),
            'changed_values' => $model->getDirty(),
            'old_values' => $model->getOriginal(),
            'new_values' => $model->toArray()
        ]);

        // Второе кастомное событие
        //AfterStoredLogEvent::dispatch();

        return $log;
    }
}
