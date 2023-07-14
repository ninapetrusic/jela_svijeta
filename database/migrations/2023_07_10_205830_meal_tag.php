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
        Schema::create('meal_tag', function($table) {
            $table->increments('id');
            $table->integer('meal_id')->unsigned()->references('meals')->on('id')->onDelete('cascade');
            $table->integer('tag_id')->unsigned()->references('tags')->on('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_tag');
    }
};
