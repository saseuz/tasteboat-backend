<?php

namespace Database\Factories;

use App\Models\Backend\Recipe;
use App\Models\User;
use App\Models\Backend\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recipe_id' => Recipe::inRandomOrder()->value('id') ?? Recipe::factory(),
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            // 'parent_id' => Comment::factory(),
            'content' => fake()->sentence(),
        ];
    }
}
