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
        Schema::create('ingredients', function($table) {
            $table->increments('id');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('ingredient_translations', function($table) {
            $table->increments('id');
            $table->integer('ingredient_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title');

            $table->unique(['ingredient_id', 'locale']);
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('ingredient_translations');
    }
};
