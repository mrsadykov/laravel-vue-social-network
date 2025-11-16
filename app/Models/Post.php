<?php

namespace App\Models;

use App\Http\Resources\Image\ImageCollection;
use App\Traits\HasFilter;
use App\Traits\HasLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

//#[ObservedBy(PostObserver::class)]
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasLog;
    use HasFilter;

    // считает, передаем названия отношений
    protected $withCount = [
        'likedByProfiles',
        'viewedByProfiles'
    ];

    protected $fillable = [
        'title',
        'content',
        'image',
        'video',
        'published_at',
        'is_active',
        'category_id',
        'profile_id',
        'signature'
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // какими профилями был отлайкан этот пост
    /*public function likedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'post_profile_likes');
    }*/

    public function likedByProfiles(): MorphToMany
    {
        return $this->morphToMany(Profile::class, 'likeable');
    }

    // просмотры - какими профилями был просмотрен пост
    /*public function viewedByProfiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'post_profile_views');
    }*/

    public function viewedByProfiles(): MorphToMany
    {
        return $this->morphToMany(Profile::class, 'viewable');
    }

    // репосты
    /*public function repostedByProfile(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'post_profile_reposts');
    }*/
    public function repost(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    // hasOne -> morphOne
    /*public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }*/

    public function comments(): HasMany /*MorphMany*/
    {
        return $this->hasMany(Comment::class)->latest()->with('answers');
        // временно
        //return $this->morphMany(Comment::class, 'commentable');
    }

    /*public function getImgUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->img_path);
    }*/

    // у поста может быть много картинок
    public function images(): morphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /*public function getImagesAttribute()
    {
        return ImageCollection::make($this?->images()->get())->resolve();

        // старый вариант
        $paths = [];
        foreach ($arr as $path) {
            $paths[] = Storage::disk('public')->url($path);
        }
        return $paths;
    }*/

    // проверяем есть ли отношение статьи с текущим профилем пользователя
    // те есть ли в таблице запись с текущим постом и текущем профилем пользователя
    public function getIsLikedAttribute(): bool
    {
        // $this->likedByProfiles - возвращает коллекцию
        return $this->likedByProfiles->contains(auth()->user()->profile->id);
    }
}
