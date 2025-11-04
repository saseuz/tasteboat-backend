<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeApiRequest;
use App\Models\Backend\Recipe;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    use HasImageUpload;
    
    public function list()
    {
        $recipes = Recipe::latest()->paginate();

        return response()->json([
            'recipes' => $recipes
        ]);
    }

    public function store(RecipeApiRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;

        if ($request->hasFile('image')) {
            // Thumbnail Image
            $validatedData['thumbnail'] = $this->saveImage($request->file('image'), 'recipes/thumbnails', 800, 600);

            // Cover Image
            $validatedData['image'] = $this->saveImage($request->file('image'), 'recipes', 1200, 800);
        }

        $recipe = Recipe::create($validatedData);
        $recipe->categories()->attach($validatedData['categories']);

        $recipe->ingredients()->createMany($validatedData['ingredients']);

        return response()->json([
            'status' => 'success',
            'response_code' => 201,
            'message' => 'Recipe created successfully.',
            'data' => $recipe,
        ], 201);
    }

    public function detail(string $slug)
    {
        $recipe = Recipe::where('slug', $slug)->first();

        return response()->json([
            'status' => 'success',
            'response_code' => 200,
            'message' => 'Recipe detail info.',
            'data' => $recipe,
        ], 200);
    }
}
