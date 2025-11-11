<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeDetailResource;
use App\Models\Backend\Recipe;
use Illuminate\Http\Request;

class RecipeRatingController extends Controller
{
    public function store(string $slug, Request $request)
    {
        $request->validate([
            'rating'  =>  'required|integer|min:1|max:5',
        ]);

        $recipe = Recipe::where('slug', $slug)->first();

        $recipe->ratings()->updateOrCreate(
            [
                'user_id' => auth('api')->user()->id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        return new RecipeDetailResource($recipe)->additional([
                    'status' => 'success',
                    'response_code' => 200,
                    'message' => 'Rating submitted successfully.',
                ])
                ->response()
                ->setStatusCode(200);
    }
}
