<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Recipe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('user')->latest()->paginate(10);

        return Inertia::render('Recipe/Index', [
            'recipes' => $recipes
        ]);
    }

    public function show(string $id)
    {
        dd($id);

        $recipe = Recipe::findOrFail($id);

        return Inertia::render('Recipe/Show', [
            'recipe' => $recipe
        ]);
    }
}
