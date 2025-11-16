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
        // лайки к комментам и постам
        Schema::create('likeables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('profile_id')->index()->constrained('profiles');
            $table->morphs('likeable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likeables');
    }
};
