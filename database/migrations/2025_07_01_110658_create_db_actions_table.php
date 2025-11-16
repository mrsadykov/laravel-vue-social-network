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
        Schema::create('db_actions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->text('sql')->nullable();
            $table->text('table')->nullable();
            $table->integer('status')->nullable();
            $table->string('duration')->nullable();
            $table->timestamp('timestamp')->nullable();
            $table->text('message')->nullable();
            $table->string('route')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('db_actions');
    }
};
