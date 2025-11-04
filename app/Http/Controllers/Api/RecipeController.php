<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeApiRequest;
use App\Http\Resources\RecipeDetailResource;
use App\Http\Resources\RecipeListResource;
use App\Http\Resources\RecipeResource;
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
        
        return RecipeListResource::collection($recipes)->additional([
                    'status' => 'success',
                    'response_code' => 200,
                    'message' => 'Recipes retrieved successfully',
                ])
                ->response()
                ->setStatusCode(200);
    }

    public function myRecipes(): JsonResponse
    {
        $recipes = Recipe::where('user_id', auth()->user()->id)->latest()->paginate();

        return RecipeListResource::collection($recipes)->additional([
                    'status' => 'success',
                    'response_code' => 200,
                    'message' => 'My recipes retrieved successfully',
                ])
                ->response()
                ->setStatusCode(200);
    }

    public function store(RecipeApiRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        // json_decode ingredients|string to array

        if ($request->hasFile('image')) {
            // Thumbnail Image
            $validatedData['thumbnail'] = $this->saveImage($request->file('image'), 'recipes/thumbnails', 800, 600);

            // Cover Image
            $validatedData['image'] = $this->saveImage($request->file('image'), 'recipes', 1200, 800);
        }

        $recipe = Recipe::create($validatedData);
        $recipe->categories()->attach($validatedData['categories']);

        $recipe->ingredients()->createMany($validatedData['ingredients']);

        return new RecipeDetailResource($recipe)->additional([
                    'status' => 'success',
                    'response_code' => 201,
                    'message' => 'Recipe created successfully.',
                ])
                ->response()
                ->setStatusCode(201);
    }

    public function detail(string $slug): JsonResponse
    {
        $recipe = Recipe::with('categories', 'ingredients', 'comments.replies', 'comments.user', 'user')
                    ->where('slug', $slug)->first();

        return new RecipeDetailResource($recipe)->additional([
                    'status' => 'success',
                    'response_code' => 200,
                    'message' => 'Recipe detail info.',
                ])
                ->response()
                ->setStatusCode(200);
    }

    public function update(RecipeApiRequest $request, string $slug): JsonResponse
    {
        $recipe = Recipe::where('slug', $slug)->firstOrFail();
        $validatedData = $request->validated();

        if ($recipe->user_id !== auth()->user()->id) {
            return new RecipeDetailResource($recipe)->additional([
                    'status' => 'error',
                    'response_code' => 403,
                    'message' => 'You are not authorized to update this recipe.',
                ])
                ->response()
                ->setStatusCode(403);
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

        return new RecipeDetailResource($recipe)->additional([
                    'status' => 'success',
                    'response_code' => 200,
                    'message' => 'Recipe updated successfully',
                ])
                ->response()
                ->setStatusCode(200);
    }

    public function destroy(string $slug): JsonResponse
    {
        $recipe = Recipe::where('slug', $slug)->firstOrFail();

        if ($recipe->user_id !== auth()->user()->id) {
            return new RecipeDetailResource($recipe)->additional([
                    'status' => 'error',
                    'response_code' => 403,
                    'message' => 'You are not authorized to delete this recipe.',
                ])
                ->response()
                ->setStatusCode(403);
        }

        $recipe->delete();

        return new RecipeDetailResource($recipe)->additional([
                    'status' => 'success',
                    'response_code' => 204,
                    'message' => 'Recipe deleted successfully.',
                ])
                ->response()
                ->setStatusCode(204);
    }
}
