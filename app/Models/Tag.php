<?php

namespace App\Models;

use App\Traits\HasFilter;
use App\Traits\HasLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;
    use HasLog;
    use HasFilter;

    protected $fillable = [
        'title'
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
