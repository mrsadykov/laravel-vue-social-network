<?php

namespace App\Models;

use App\Traits\HasFilter;
use App\Traits\HasLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Profile extends Model
{
    use HasFactory;
    use HasLog;
    use HasFilter;

    protected $fillable = [
        'second_name',
        'third_name',
        'image',
        'city',
        'login',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->latest();
    }

    public function chats(): BelongsToMany //HasMany
    {
        //return $this->hasMany(Chat::class);
        return $this->belongsToMany(Chat::class);
    }

    // какие посты были отлайканы текущим профилем
    /*public function likedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_profile_likes');
    }*/

    public function likedPosts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'likeable');
    }

    public function likedComments(): MorphToMany
    {
        return $this->morphedByMany(Comment::class, 'likeable');
    }

    // просмотренные посты - переделать под полиморф
    /*public function viewedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_profile_views');
    }*/
    public function viewedPosts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'viewable');
    }

    // hasOne -> morphOne
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    // подписки
    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class,
            'follower_following',
            // относится к текущему профилю
            'follower_id',
            'following_id'
        );
    }

    // подписан ли текущий пользователь на указанный профиль
    public function getIsFollowedAttribute(): bool
    {
        return $this->followers->contains(auth()->user()->profile->id);
    }

    // подписчики
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class,
            'follower_following',
            'following_id',
            'follower_id'
        );
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(UserNotification::class, 'profile_id', 'id')
            ->whereNull('read_at')
            ->latest();
    }
}
