<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeDetailResource;
use App\Http\Resources\RecipeListResource;
use App\Models\Backend\Favourite;
use App\Models\Backend\Recipe;
use Illuminate\Http\Request;

class RecipeFavouriteController extends Controller
{
    public function favouriteRecipes()
    {
        $recipes = Recipe::with('categories')
                    ->whereHas('favourites', function ($query) {
                        $query->where('user_id', auth()->user()->id);
                    })->latest()->paginate();

        return RecipeListResource::collection($recipes)->additional([
                    'status' => 'success',
                    'response_code' => 200,
                    'message' => 'Favourite recipes retrieved successfully',
                ])
                ->response()
                ->setStatusCode(200);
    }

    public function favouriteToggle(string $slug)
    {
        $recipe = Recipe::with('categories', 'ingredients', 'comments.replies', 'comments.user', 'user')
                    ->where('slug', $slug)
                    ->firstOrFail();
                    
        $user = auth()->user();

        $favourite = Favourite::where('user_id', $user->id)
                                ->where('recipe_id', $recipe->id)
                                ->exists();

        if ($favourite) {

            $user->favouriteRecipes()->detach($recipe->id);

            return new RecipeDetailResource($recipe)->additional([
                    'status' => 'success',
                    'response_code' => 200,
                    'message' => 'Recipe removed from favourites.',
                ])
                ->response()
                ->setStatusCode(200);

        }

        $user->favouriteRecipes()->attach($recipe->id);
        
        return new RecipeDetailResource($recipe)->additional([
                    'status' => 'success',
                    'response_code' => 200,
                    'message' => 'Recipe added to favourites.',
                ])
                ->response()
                ->setStatusCode(200);
    }
}
