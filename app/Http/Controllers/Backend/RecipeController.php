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
    public function index(Request $request)
    {
        $recipes = Recipe::with('user')
                    ->when($request->filter == 'trashed', fn ($q) => $q->onlyTrashed())
                    ->latest()
                    ->paginate();

        return Inertia::render('Recipe/Index', [
            'recipes' => $recipes,
            'filter' => $request->filter,
        ]);
    }

    public function show(string $id)
    {
        $recipe = Recipe::with(['user', 'cuisine', 'categories'])
                    ->withTrashed()
                    ->findOrFail($id);

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
        $recipe = Recipe::withTrashed()->findOrFail($id);
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

    public function toggleTrashed(string $id)
    {
        $recipe = Recipe::withTrashed()->findOrFail($id);

        if ($recipe->deleted_at) {
            $recipe->restore();
            $message = ' has been restored.';
        } else {
            $recipe->delete();
            $message = ' moved to trashed.';
        }

        return redirect()->route(admin_route_name() . 'recipes.index')
            ->with('success', $recipe->title . $message);
    }
}
