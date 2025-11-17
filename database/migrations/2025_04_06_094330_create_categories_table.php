<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title', 500); // До 500 символов
            $table->timestamps();

            // Теперь можно безопасно создать индекс
            $table->index('title');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
