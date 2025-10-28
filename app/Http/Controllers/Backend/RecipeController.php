<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Enums\RecipeStatus;
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
            'favourite_count' => $recipe->favouriteCount(),
        ]);
    }

    public function toggleStatus(Request $request, string $id)
    {
        $recipe = Recipe::findOrFail($id);
        $status = $request->status;

        if ($status === RecipeStatus::DRAFT->value) {
            $status = RecipeStatus::PUBLISHED->value;
        } else {
            $status = RecipeStatus::DRAFT->value;
        }
        
        $recipe->update([
            'status' => $status
        ]);

        return redirect()->route(admin_route_name() . 'recipes.index')
            ->with('success', $recipe->title . ' status updated successfully.');
    }
}
