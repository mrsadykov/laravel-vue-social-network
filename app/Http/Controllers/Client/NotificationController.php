<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Notification\UpdateMultipleRequest;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\UserNotification;
use App\Services\UserNotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = UserNotification::query()
            ->where('profile_id', auth()->user()->profile->id)
            ->orderBy('id', 'desc')
            ->paginate(
                10,
                '*',
                'page',
                1
            );

        $notifications = NotificationResource::collection($notifications);

        return inertia('Client/Notification/Index', compact('notifications'));
    }

    public function updateMarkAllAsRead(UpdateMultipleRequest $request)
    {
        $data = $request->validated();
        $notifications = UserNotificationService::updateMarkAllAsRead($data);
        return NotificationResource::collection($notifications);
    }
}
