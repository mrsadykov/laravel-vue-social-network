<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Role\StoreRequest;
use App\Http\Requests\Api\Role\UpdateRequest;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RoleResource::make(Role::all())->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $role = RoleService::create($data);
        return RoleResource::make($role)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return RoleResource::make($role)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Role $role)
    {
        $data = $request->validated();
        $role = RoleService::update($role, $data);
        return RoleResource::make($role)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        RoleService::delete($role);
        return response()->json([
            'message' => 'Role deleted'
        ], Response::HTTP_OK);
    }
}
