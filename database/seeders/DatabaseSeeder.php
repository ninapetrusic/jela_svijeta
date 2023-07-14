<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Meal;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Ingredient::factory(10)->create();
        Category::factory(10)->create();
        Tag::factory(10)->create();
        Meal::factory(10)->create();

        $tags = Tag::all();
        $ingredients = Ingredient::all();

        Meal::all()->each(function ($meal) use ($tags) {
            $meal->tags()->attach(
                $tags->random(rand(1,5))->pluck('id')->toArray()
            );
        });
        
        Meal::all()->each(function ($meal) use ($ingredients) {
            $meal->ingredients()->attach(
                $ingredients->random(rand(1,5))->pluck('id')->toArray()
            );
        });
    }
}
