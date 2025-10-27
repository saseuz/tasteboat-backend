<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Comment;
use App\Models\Backend\Recipe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('user')->latest()->paginate();

        return Inertia::render('Recipe/Index', [
            'recipes' => $recipes
        ]);
    }

    public function show(string $id)
    {
        $recipe = Recipe::with(['user', 'cuisine', 'categories'])->findOrFail($id);
        $comments = Comment::where('recipe_id', $recipe->id)
                        ->whereNull('parent_id')
                        ->with(['user', 'replies.user'])
                        ->latest()
                        ->get();

        return Inertia::render('Recipe/Show', [
            'recipe' => $recipe,
            'avg_ratings' => $recipe->avergeRatings(),
            'categories' => $recipe->categories()->limit(3)->pluck('name'),
            'c_count' => $recipe->categories->count(),
            'comments' => $comments,
            'ingredients' => $recipe->ingredients,
        ]);
    }
}
