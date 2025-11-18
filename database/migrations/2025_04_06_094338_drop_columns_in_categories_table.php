<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Удаление лишних атрибутов и их индексов
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'user_id')) {
                $table->dropForeign(['user_id']); // Удаляем внешний ключ
                $table->dropIndex([ 'user_id' ]); // Теперь можно удалить индекс
                $table->dropColumn('user_id');// И наконец колонку
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('user_id')->index()->nullable()->constrained('users');
        });
    }
};
