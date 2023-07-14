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
        Schema::create('meals', function($table) {
            $table->increments('id');
            $table->text('description');
            //ids
            $table->integer('category')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('category')->references('id')->on('categories');

            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('meal_translations', function($table) {
            $table->increments('id');
            $table->integer('meal_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title');

            $table->unique(['meal_id','locale']);
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
        Schema::dropIfExists('meal_translations');
    }
};
