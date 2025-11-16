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
        // полиморфная сущность
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('content');
            $table->dateTime('published_at');

            $table->foreignId('profile_id')->index()->constrained('profiles');
            $table->foreignId('post_id')->index()->nullable()->constrained('posts')->nullOnDelete();
            //$table->morphs('commentable');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
