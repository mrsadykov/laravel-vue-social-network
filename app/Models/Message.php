<?php

namespace App\Models;

use App\Traits\HasFilter;
use App\Traits\HasLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;
    use HasLog;
    use HasFilter;

    protected $fillable = [
        'content',
        'published_at',
        'chat_id',
        'profile_id'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function getFormattedDateAttribute(): string
    {
        return $this?->published_at?->diffForHumans();
    }

    public function getIsOwnerAttribute(): bool
    {
        return auth()->user()->profile->id == $this->profile_id;
    }
}
