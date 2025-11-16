<?php

namespace App\Http\Middleware;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // $user = $request->user()->with([
        //     'profile',
        //     'chats',
        //     'comments',
        //     'messages',
        //     'posts',
        //     'roles',
        //     'permissions'
        // ]);

        // dd(auth()->user()->with([
        //     'profile'
        // ])->first(), $request->user()->with([
        //     'profile'
        // ])->first());

        $user = $request->user();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? UserResource::make($user)->resolve() : $user,
            ],
        ];
    }
}
