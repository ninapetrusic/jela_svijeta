<?php

namespace Database\Factories;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'slug' => $this->faker->slug(),
            'en' => ['title' => $this->faker->word()],
            'fr' => ['title' => $this->faker->word()],
            'de' => ['title' => $this->faker->word()]
        ];
    }
}
