<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeApiRequest;
use App\Models\Backend\Recipe;
use App\Traits\HasImageUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    use HasImageUpload;
    
    public function list(): JsonResponse
    {
        $recipes = Recipe::latest()->paginate();

        return response()->json([
            'recipes' => $recipes
        ]);
    }

    public function myRecipes(): JsonResponse
    {
        $recipes = Recipe::where('user_id', auth()->user()->id)->latest()->paginate();

        return response()->json([
            'status' => 'success',
            'response_code' => 200,
            'message' => 'My recipes retrieved successfully',
            'data' => $recipes,
        ], 200);
    }

    public function store(RecipeApiRequest $request): JsonResponse
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

    public function detail(string $slug): JsonResponse
    {
        $recipe = Recipe::where('slug', $slug)->first();

        return response()->json([
            'status' => 'success',
            'response_code' => 200,
            'message' => 'Recipe detail info.',
            'data' => $recipe,
        ], 200);
    }

    public function update(RecipeApiRequest $request, string $slug): JsonResponse
    {
        $recipe = Recipe::where('slug', $slug)->firstOrFail();
        $validatedData = $request->validated();

        if ($recipe->user_id !== auth()->user()->id) {
            return response()->json([
                'status' => 'error',
                'response_code' => 403,
                'message' => 'You are not authorized to update this recipe.',
                'data' => $recipe,
            ], 403);
        }

        if ($request->hasFile('image')) {
            // Delete old images
            $this->deleteOldImage($recipe->thumbnail, 'recipes/thumbnails');
            $this->deleteOldImage($recipe->image, 'recipes');

            // Thumbnail Image
            $validatedData['thumbnail'] = $this->saveImage($request->file('image'), 'recipes/thumbnails', 800, 600);

            // Cover Image
            $validatedData['image'] = $this->saveImage($request->file('image'), 'recipes', 1200, 800);
        }

        $recipe->update($validatedData);
        if (isset($validatedData['categories'])) {
            $recipe->categories()->sync($validatedData['categories']);
        }

        if (isset($validatedData['ingredients'])) {
            $recipe->ingredients()->delete();
            $recipe->ingredients()->createMany($validatedData['ingredients']);
        }

        return response()->json([
            'status' => 'success',
            'response_code' => 200,
            'message' => 'Recipe updated successfully.',
            'data' => $recipe,
        ], 200);
    }

    public function destroy(string $slug): JsonResponse
    {
        $recipe = Recipe::where('slug', $slug)->firstOrFail();

        if ($recipe->user_id !== auth()->user()->id) {
            return response()->json([
                'status' => 'error',
                'response_code' => 403,
                'message' => 'You are not authorized to delete this recipe.',
                'data' => $recipe,
            ], 403);
        }

        $recipe->delete();

        return response()->json([
            'status' => 'success',
            'response_code' => 204,
            'message' => 'Recipe deleted successfully.',
            'data' => $recipe,
        ], 204);
    }
}
