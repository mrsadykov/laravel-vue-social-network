<?php

namespace App\Models;

use App\Traits\HasFilter;
use App\Traits\HasLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Comment extends Model
{
    use HasFactory;
    use HasLog;
    use HasFilter;

    protected $fillable = [
        'content',
        'published_at',
        'profile_id',
        'post_id'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    protected $withCount = [
        'likedByProfiles'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function category(): BelongsTo
    {
        return $this->post->category();
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function likedByProfiles(): MorphToMany
    {
        return $this->morphToMany(Profile::class, 'likeable');
    }

    public function getFormattedDateAttribute()
    {
        return $this?->published_at?->diffForHumans();
    }

    // проверяем есть ли отношение комментария с текущим профилем
    // те проверка существования записи в таблице likeables
    // c текущем profile_id
    // c likeable_type App/Models/Comment
    // c likeable_id $this->id
    public function getIsLikedAttribute(): bool
    {
        return $this->likedByProfiles->contains(auth()->user()->profile->id);
    }

    // устанавливается связь между комментарием и его родительским комментарием
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    // устанавливается связь между комментарием и его дочерними комментариями
    public function answers(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }
}
