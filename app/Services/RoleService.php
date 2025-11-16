<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public static function create($data)
    {
        return Role::query()->create($data);
    }

    public static function update(Role $role, array $data)
    {
        $role->update($data);
        return $role;
    }

    public static function delete(Role $role)
    {
        $role->delete();
        return $role;
    }
}
