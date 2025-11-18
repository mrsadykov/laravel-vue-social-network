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
            if (Schema::hasColumn('categories', 'some_int_field')) {
                $table->dropColumn('some_int_field');
            }

            if (Schema::hasColumn('categories', 'some_int_field2')) {
                $table->dropColumn('some_int_field2');
            }

            if (Schema::hasColumn('categories', 'some_text_field')) {
                $table->dropColumn('some_text_field');
            }

            if (Schema::hasColumn('categories', 'some_text_field2')) {
                $table->dropColumn('some_text_field2');
            }

            if (Schema::hasColumn('categories', 'user_id')) {
                $table->dropIndex([ 'some_index' ]);
                $table->dropColumn('some_index');
                $table->dropIndex([ 'user_id' ]);
                $table->dropColumn('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->text('some_text_field')->nullable();
            $table->unsignedBigInteger('some_int_field')->nullable();
            $table->bigInteger('some_int_field2')->nullable();
            $table->string('some_text_field2')->nullable();
            $table->string('some_index')->nullable();
            $table->index('some_index');
            //$table->foreignId('user_id')->index()->nullable()->constrained('users');

            $table->dropForeign(['user_id']); // Удаляем внешний ключ
            $table->dropIndex([ 'user_id' ]); // Теперь можно удалить индекс
            $table->dropColumn('user_id');// И наконец колонку
        });
    }
};
