<?php

namespace App\Http\Controllers\Client;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UserNotification;
use App\Http\Controllers\Controller;
use App\Services\UserNotificationService;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Profile\ProfileResource;
use App\Http\Requests\Client\Post\StoreRepostRequest;
use App\Http\Resources\Notification\NotificationResource;
use App\Http\Requests\Client\Profile\IndexNotificationRequest;

class ProfileController extends Controller
{
    public function self()
    {
        $posts = auth()->user()->posts;
        $posts = PostResource::collection($posts)->resolve();
        return inertia('Client/Profile/Self', compact('posts'));
    }

    public function show(Profile $profile)
    {
        $posts = $profile->posts;
        $posts = PostResource::collection($posts)->resolve();

        // подписан ли текущий пользователь (профиль)
        //$isFollowed = auth()->user()->profile->followings->contains($profile->id);

        if ($profile->id == auth()->user()->profile->id) {
            return inertia('Client/Profile/Self', compact('posts'));
        }

        $profile = ProfileResource::make($profile)->resolve();
        return inertia('Client/Profile/Show', compact('posts', 'profile', /*'isFollowed'*/));
    }

    public function repost(Post $post, StoreRepostRequest $request)
    {
        $data = $request->validated();
        $data = array_merge($data, [
            'title' => $post->title,
            'content' => $post->content,
            'parent_id' => $post->id
        ]);

        Post::query()->create($data);

        return response()->json([
            'message' => 'Статья успешно репостнута!',
        ], Response::HTTP_OK);
    }

    public function toggleFollowing(Profile $profile)
    {
        // $profile - на кого хотим подсписаться
        // мои подписки
        $res = auth()->user()->profile->followings()->toggle($profile->id);

        return response()->json([
            // подписан?
            'is_followed' => count($res['attached']) > 0,
        ], Response::HTTP_OK);
    }

    public function index()
    {
        $profiles = Profile::all();
        $profiles = ProfileResource::collection($profiles)->resolve();
        return inertia('Client/Profile/Index', compact('profiles'));
    }

    public function indexNotification(IndexNotificationRequest $request)
    {
        $data = $request->validated();

        $notifications = auth()->user()->profile
            ->notifications()
            ->paginate(
                2,
                '*',
                'page',
                $data['page']
            );

        //dd($notifications);

        // обновить записи (сделать прочитанными)
        UserNotificationService::update($notifications->pluck('id')->toArray());

        return NotificationResource::collection($notifications);
    }

    public function notificationCount()
    {
        return auth()->user()->profile
            ->notifications()
            ->count();
    }
}
