<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'model',
        'event',
        'old_values',
        'new_values',
        'changed_values'
    ];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
        'changed_values' => 'json'
    ];
}
