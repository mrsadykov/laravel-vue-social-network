<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\StoreRequest;
use App\Http\Requests\Api\User\UpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all())->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $user = UserService::create($data);
        return UserResource::make($user)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return UserResource::make($user)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user)
    {
        $data = $request->validated();
        $user = UserService::update($user, $data);
        return UserResource::make($user)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        UserService::delete($user);
        return response()->json([
            'message' => 'User deleted',
        ], Response::HTTP_OK);
    }
}
