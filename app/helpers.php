<?php

use Illuminate\Support\Facades\Log;
use App\Events\Log\AfterStoredLogEvent;
//use App\Models\Log;
use Illuminate\Database\Eloquent\Model;
use App\Events\Log\BeforeStoredLogEvent;

if (!function_exists('logModelChange')) {

    // 8 урок
    // function logModelChange(string $functionName, Model $model)
    // {
    //     // Первое кастомное событие
    //     //BeforeStoredLogEvent::dispatch();

    //     Log::query()->create([
    //         'event' => $functionName,
    //         'model' => get_class($model),
    //         'changed_values' => $model->getDirty(),
    //         'old_values' => $model->getOriginal(),
    //         'new_values' => $model->toArray()
    //     ]);

    //     // Второе кастомное событие
    //     //AfterStoredLogEvent::dispatch();
    // }

    function logModelChange(string $functionName, Model $model)
    {
        // Первое кастомное событие
        //BeforeStoredLogEvent::dispatch();

        switch ($functionName) {
            case 'created':
            case 'updated':
                $data = [
                    'id' => $model->id,
                    'data' => $model->getDirty()
                ];
                break;
            case 'retrieved':
            case 'deleted':
                $data = [
                    'id' => $model->id
                ];
                break;
        }

        $namespaceArray = explode('\\', $model::class);
        $modelClassName = array_pop($namespaceArray);

        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/' . $modelClassName . '/' . $functionName . '.log')
        ])->info('', $data);

        // Второе кастомное событие
        //AfterStoredLogEvent::dispatch();
    }
}