<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Backend\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function list()
    {
        $recipes = Recipe::latest()->get();

        return response()->json([
            'recipes' => $recipes
        ]);
    }

    public function create(Request $request)
    {
        dd($request->all());
    }

    public function detail(string $id)
    {
        $recipe = Recipe::findOrFail($id);

        return response()->json([
            'recipe' => $recipe
        ]);
    }

    
}
