<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Изменить некорректные атрибуты в нужный тип
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('some_int_field2')->nullable()->change();
            $table->text('some_text_field2')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->bigInteger('some_int_field2')->nullable()->change();
            $table->string('some_text_field2')->nullable()->change();
        });
    }
};
