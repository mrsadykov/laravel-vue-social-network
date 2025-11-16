<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Video::factory(10)->create();
    }
}
