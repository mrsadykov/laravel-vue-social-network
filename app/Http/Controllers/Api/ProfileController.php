<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\IndexRequest;
use App\Http\Requests\Api\Profile\StoreRequest;
use App\Http\Requests\Api\Profile\UpdateRequest;
use App\Http\Resources\Profile\ProfileResource;
use App\Models\Profile;
use App\Services\ProfileService;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        $profiles = Profile::filter($data)->get();
        return ProfileResource::make($profiles)->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $profile = ProfileService::create($data);
        return ProfileResource::make($profile)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        return ProfileResource::make($profile)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Profile $profile)
    {
        $data = $request->validated();
        $profile = ProfileService::update($profile, $data);
        return ProfileResource::make($profile)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        ProfileService::delete($profile);
        return response()->json([
            'message' => 'Profile deleted'
        ], Response::HTTP_OK);
    }
}
