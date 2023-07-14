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
        Schema::create('tags', function($table) {
            $table->increments('id');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('tag_translations', function($table) {
            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title');

            $table->unique(['tag_id', 'locale']);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('tag_translations');
    }
};
