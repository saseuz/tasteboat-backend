<?php

namespace Database\Factories;

use App\Enums\Enums\RecipeDifficulty;
use App\Enums\Enums\RecipeStatus;
use App\Models\Backend\Cuisine;
use App\Models\Backend\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'user_id' => User::factory(),
            'cuisine_id' => Cuisine::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'instructrions' => fake()->text(300),
            'thumbnail' => fake()->imageUrl(640, 480, 'recipe', true),
            'prep_time' => fake()->numberBetween(1, 10),
            'cook_time' => fake()->numberBetween(10, 60),
            'servings' => fake()->numberBetween(1, 20),
            'difficulty' => fake()->randomElement(RecipeDifficulty::class),
            'status' => fake()->randomElement(RecipeStatus::class),
        ];
    }
}
