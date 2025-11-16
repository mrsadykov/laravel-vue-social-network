<?php

namespace App\Models;

use App\Traits\HasFilter;
use App\Traits\HasLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
{
    use HasFactory;
    use HasLog;
    use HasFilter;

    protected $fillable = [
        'title'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    // связь через - комментарии постов
    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(Comment::class, Post::class);
    }

    protected static function booted()
    {
        static::created(function(Category $category) {
            //dump('from model');
        });
    }
}
