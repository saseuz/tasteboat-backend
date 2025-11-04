<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Backend\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function list()
    {
        $recipes = Recipe::latest()->paginate();

        return response()->json([
            'recipes' => $recipes
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function detail(string $slug)
    {
        $recipe = Recipe::where('slug', $slug)->first();

        return response()->json([
            'recipe' => $recipe
        ]);
    }
}
