<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all())->resolve();
    }

    public function show(User $user)
    {
        return UserResource::make($user)->resolve();
    }

    public function store()
    {
        $data = [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => Hash::make(Str::random(10)),
        ];

        $user = User::query()->create($data);
        return UserResource::make($user)->resolve();
    }

    public function update(User $user)
    {
        $data = [
            'name' => 'John ' . md5(now())
        ];

        $user->update($data);
        return UserResource::make($user)->resolve();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response([
            'message' => 'User deleted'
        ]);
    }
}
