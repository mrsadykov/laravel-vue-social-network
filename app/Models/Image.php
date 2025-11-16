<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'path',
        'imageable'
    ];

    // Полиморфная связь - 1 картинка к любой модели
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    /*public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->path);
    }*/
}
