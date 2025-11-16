<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // все посты текущего пользователя
        /*$posts = Post::query()
            ->where('profile_id', auth()->user()->profile->id)
            ->latest()
            ->get();*/

        $posts = PostResource::collection(auth()->user()->profile->posts()->with([
            'profile' => [
                'followers',
                'image'
            ],
            'tags',
            'category',
            'likedByProfiles',
            'viewedByProfiles',
            'repost',
            'images'
        ])->get())->resolve();

        return inertia('Client/Dashboard/Index', compact('posts'));
    }
}
