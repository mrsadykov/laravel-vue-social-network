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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title', 500)->unique();
            $table->text('content');
            $table->string('img_path')->nullable();
            $table->string('video')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->boolean('is_active')->default(true);

            $table->foreignId('category_id')->nullable()->index()->constrained('categories');
            $table->foreignId('profile_id')->index()->constrained('profiles');
            $table->foreignId('parent_id')->index()->nullable()->constrained('posts');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
