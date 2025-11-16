<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create users
        $adminUser = User::query()->firstOrCreate(
            [ 'email' => 'admin@mail.com' ],
            [
                'name' => 'admin',
                'password' => Hash::make('admin')
            ]
        );

        $adminUser->profile()->create([
            'user_id' => $adminUser->id,
            'login' => 'user'
        ]);

        $moderatorPostsUser = User::query()->create([
            'email' => 'posts@mail.com',
            'name' => 'posts',
            'password' => Hash::make('posts')
        ]);

        $moderatorVideosUser = User::query()->create([
            'email' => 'videos@mail.com',
            'name' => 'videos',
            'password' => Hash::make('videos')
        ]);

        // create roles
        $roles = [
            [
                'title' => 'admin',
            ],
            [
                'title' => 'moderator_posts',
            ],
            [
                'title' => 'moderator_videos',
            ],
        ];

        // create permissions
        $permissions = [
            [
                'title' => 'store'
            ],
            [
                'title' => 'index'
            ],
            [
                'title' => 'update'
            ],
            [
                'title' => 'delete'
            ]
        ];

        // for moderator_posts and moderator_videos role show, store, update permissions
        foreach ($permissions as $permission) {
            $permission = Permission::query()->create($permission);
            switch ($permission->title) {
                case 'store':
                    $storePermissionId = $permission->id;
                    break;
                case 'index':
                    $indexPermissionId = $permission->id;
                    break;
                case 'update':
                    $updatePermissionId = $permission->id;
                    break;
            }
        }

        // result
        foreach ($roles as $role) {
            $role = Role::query()->create($role);

            if ($role->title == 'admin') {
                $adminUser->roles()->sync($role->id);
            }

            if ($role->title == 'moderator_posts') {
                $moderatorPostsUser->roles()->sync($role->id);
                $role->permissions()->sync([
                    $storePermissionId,
                    $indexPermissionId,
                    $updatePermissionId
                ]);
            }

            if ($role->title == 'moderator_videos') {
                $moderatorVideosUser->roles()->sync($role->id);
                $role->permissions()->sync([
                    $storePermissionId,
                    $indexPermissionId,
                    $updatePermissionId
                ]);
            }
        }
    }
}
