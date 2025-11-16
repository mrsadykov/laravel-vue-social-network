<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\UserNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserNotificationService
{
    public static function update(array $ids)
    {
        UserNotification::whereIn('id', $ids)->update([
            'read_at' => now()
        ]);
    }

    public static function updateMarkAllAsRead(array $data)
    {
        UserNotification::query()->update([ 'read_at' => now() ]);

        $notifications = UserNotification::query()->orderBy('id', 'desc')->get();

        return $notifications;
    }

    public static function store(Comment $comment): UserNotification
    {
        DB::beginTransaction();
        try {
            $notification = UserNotification::create([
                'profile_id' => $comment->profile_id,
                'content' => $comment->content
            ]);
            DB::commit();
            return $notification;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
