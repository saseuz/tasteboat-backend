<?php

namespace Database\Factories;

use App\Models\Backend\Ingredient;
use App\Models\Backend\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'id' => Str::uuid()->toString(),
            'name' => fake()->word(),
            'quantity' => fake()->randomNumber().fake()->word(),
            'unit' => fake()->randomNumber().fake()->word(),
            'note' => fake()->paragraph(),
            'recipe_id' => Recipe::factory(),
            
        ];
    }
}
