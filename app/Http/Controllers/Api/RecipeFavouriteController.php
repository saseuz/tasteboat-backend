<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Backend\Favourite;
use App\Models\Backend\Recipe;
use Illuminate\Http\Request;

class RecipeFavouriteController extends Controller
{
    public function favouriteRecipes()
    {
        $recipes = Recipe::whereHas('favourites', function ($query) {
                        $query->where('user_id', auth()->user()->id);
                    })->get();

        return response()->json([
            'status' => 'success',
            'response_code' => 200,
            'message' => 'Favourite recipes retrieved successfully.',
            'data' => $recipes,
        ], 200);
    }

    public function favouriteToggle(string $slug)
    {
        $recipe = Recipe::where('slug', $slug)->first();
        $user = auth()->user();

        $favourite = Favourite::where('user_id', $user->id)
                                ->where('recipe_id', $recipe->id)
                                ->exists();

        if ($favourite) {

            $user->favouriteRecipes()->detach($recipe->id);
            
            return response()->json([
                'status' => 'success',
                'response_code' => 200,
                'message' => 'Recipe removed from favourites.',
                'data' => $recipe,
            ], 200);

        }

        $user->favouriteRecipes()->attach($recipe->id);
        
        return response()->json([
            'status' => 'success',
            'response_code' => 200,
            'message' => 'Recipe added to favourites.',
            'data' => $recipe,
        ], 200);
    }
}
