<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Profile\StoreRequest;
use App\Http\Requests\Api\Profile\UpdateRequest;
use App\Http\Resources\Profile\ProfileResource;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        return ProfileResource::collection(Profile::all())->resolve();
    }

    public function show(Profile $profile)
    {
        return ProfileResource::make($profile)->resolve();
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $profile = Profile::query()->create($data);
        return ProfileResource::make($profile)->resolve();
    }

    public function update(UpdateRequest $request, Profile $profile)
    {
        $data = $request->validated();
        $profile->update($data);
        return ProfileResource::make($profile)->resolve();
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        return response([
            'message' => 'Profile deleted'
        ]);
    }
}
