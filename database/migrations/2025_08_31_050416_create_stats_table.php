<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('posts_count');
            $table->unsignedBigInteger('comments_count');
            $table->unsignedBigInteger('likes_count');
            $table->unsignedBigInteger('posts_views_count');
            $table->float('likes_to_posts_views');
            $table->float('likes_to_comments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
