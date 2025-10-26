<?php

namespace Database\Factories;

use App\Models\Backend\Favourite;
use App\Models\Backend\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FavouriteFactory extends Factory
{
    protected $model = Favourite::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'recipe_id' => Recipe::inRandomOrder()->value('id') ?? Recipe::factory(),
        ];
    }
}
