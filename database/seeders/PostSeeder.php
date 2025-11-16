<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Profile;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::factory(40)->create();
        $tags = Tag::all();
        $profiles = Profile::all();

        foreach ($posts as $post) {
            $post->tags()->attach($tags->random(random_int(1,5))->pluck('id'));
            // лайкнуть посты профилями
            $post->likedByProfiles()->attach($profiles->random(random_int(1,3))->pluck('id'));
            // добавить просмотры
            $post->viewedByProfiles()->attach($profiles->random(random_int(1,5))->pluck('id'));
        }
    }
}
