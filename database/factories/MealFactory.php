<?php

namespace Database\Factories;
use App\Models\Meal;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    protected $model = Meal::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $categories = Category::all()->random(rand(0,1))->pluck('id')->toArray();

        return [
            'en' => ['title' => $this->faker->word()],
            'fr' => ['title' => $this->faker->word()],
            'de' => ['title' => $this->faker->word()],
            'description' => $this->faker->sentence(),
            'category' => $categories[array_key_first($categories)] ?? null,
        ];
    }
}
