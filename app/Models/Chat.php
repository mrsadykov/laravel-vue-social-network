<?php

namespace App\Models;

use App\Traits\HasLog;
use App\Traits\HasFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;
    use HasLog;
    use HasFilter;

    protected $fillable = [
        'title',
        'profile_id'
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class);
    }

    public static function findChatByProfiles(array $profileIds): int|null
    {
        $profileIdsCount = count($profileIds);

        // идентификаторы чатов, в которых столько же пользователей сколь в $profileIds
        $chatIds = DB::table('chat_profile')
            ->select('chat_id')
            // идентификаторы чатов, в которых есть текущие профили
            ->whereIn('chat_id', function($query) use ($profileIds, $profileIdsCount) {
                $query
                    ->select('chat_id')
                    ->from('chat_profile')
                    ->whereIn('profile_id', $profileIds)
                    ->groupBy('chat_id')
                    ->havingRaw('COUNT(DISTINCT profile_id) = ?', [ $profileIdsCount ]);
            })
            ->groupBy('chat_id')
            ->havingRaw('COUNT(*) = ?', [ $profileIdsCount ])
            ->get()
            ->pluck('chat_id')
            ->toArray();

        if (!empty($chatIds)) {
            return $chatIds[0];
        }
        return null;
    }
}
