<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Profile;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\VideoSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            //UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            ProfileSeeder::class,
            PostSeeder::class,
            ChatSeeder::class,
            CommentSeeder::class,
            MessageSeeder::class,
            //RoleSeeder::class
            VideoSeeder::class,
        ]);
    }
}
