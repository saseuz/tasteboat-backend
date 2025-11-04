<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Backend\Recipe;
use Illuminate\Http\Request;

class RecipeCommentController extends Controller
{
    public function store(string $slug, Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|integer|exists:comments,id',
        ]);

        $recipe = Recipe::where('slug', $slug)->first();

        $comment = $recipe->comments()->create([
            'user_id' => auth()->user()->id,
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        return response()->json([
            'status' => 'success',
            'response_code' => 201,
            'message' => 'Comment submitted successfully.',
            'data' => $comment,
        ], 201);
    }
}
