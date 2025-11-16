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
        Schema::create('follower_following', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('follower_id')->index()->constrained('profiles');
            $table->foreignId('following_id')->index()->constrained('profiles');

            $table->unique([ 'follower_id', 'following_id' ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follower_following');
    }
};
