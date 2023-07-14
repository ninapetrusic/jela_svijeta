<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('languages', function($table) {
            $table->increments('id');
            $table->string('locale');

            $table->unique('locale');
        });

        DB::insert('insert into languages (locale) values (?)', ['en']);
        DB::insert('insert into languages (locale) values (?)', ['de']);
        DB::insert('insert into languages (locale) values (?)', ['fr']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
