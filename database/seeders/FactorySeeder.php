<?php

namespace Database\Seeders;

use App\Models\Backend\Category;
use App\Models\Backend\Comment;
use App\Models\Backend\Cuisine;
use App\Models\Backend\Favourite;
use App\Models\Backend\Ingredient;
use App\Models\Backend\Rating;
use App\Models\Backend\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::factory()->count(20)->create();
        $recipes = Recipe::factory()->count(20)->hasAttached($categories)->create();
        $ingredients = Ingredient::factory()->count(20)->create();

        $ratings = Rating::factory()->count(20)->create();
        $favourites = Favourite::factory()->count(50)->create();
        $comments = Comment::factory()->count(50)->create();

        echo "Factory Seeder Finished \n";
    }
}
