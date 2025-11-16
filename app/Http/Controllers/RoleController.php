<?php

namespace App\Http\Controllers;

use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return RoleCollection::collection(Role::all())->resolve();
    }

    public function show(Role $role)
    {
        return RoleResource::make($role)->resolve();
    }

    public function store()
    {
        $data = [
            'title' => 'Lorem ipsum ' . md5(now()),
        ];

        $role = Role::query()->create($data);
        return RoleResource::make($role)->resolve();
    }

    public function update(Role $role)
    {
        $data = [
            'title' => 'Edited Lorem ipsum ' . md5(now()),
        ];

        $role = $role->update($data);
        return RoleResource::make($role)->resolve();
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response([
            'message' => 'Role deleted'
        ]);
    }
}
