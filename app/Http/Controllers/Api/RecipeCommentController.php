<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Backend\Comment;
use App\Models\Backend\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipeCommentController extends Controller
{
    public function store(string $slug, Request $request): JsonResponse
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

    public function update(Comment $comment, Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        if ($comment->user_id !== auth()->user()->id) {
            return response()->json([
                'status' => 'error',
                'response_code' => 403,
                'message' => 'You are not authorized to update this comment.',
                'data' => $comment,
            ], 403);
        }

        $comment->update($validatedData);

        return response()->json([
            'status' => 'success',
            'response_code' => 200,
            'message' => 'Comment updated successfully.',
            'data' => $comment,
        ], 200);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        if ($comment->user_id !== auth()->user()->id) {
            return response()->json([
                'status' => 'error',
                'response_code' => 403,
                'message' => 'You are not authorized to delete this comment.',
                'data' => $comment,
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'status' => 'success',
            'response_code' => 204,
            'message' => 'Comment deleted successfully.',
            'data' => $comment,
        ], 204);
    }
}
