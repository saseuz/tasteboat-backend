<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
                'user_id' => auth()->user()->id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        return response()->json([
            'status' => 'success',
            'response_code' => 200,
            'message' => 'Rating submitted successfully.',
            'data' => $recipe,
        ], 200);
    }
}
