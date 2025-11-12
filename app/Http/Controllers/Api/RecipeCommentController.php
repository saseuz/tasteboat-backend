<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Backend\Comment;
use App\Models\Backend\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipeCommentController extends Controller
{
    public function commentsByRecipe(string $slug): JsonResponse
    {
        $recipe = Recipe::where('slug', $slug)->first();

        return CommentResource::collection($recipe->commentsWithoutReplies)->additional([
                    'status' => 'success',
                    'response_code' => 200,
                    'message' => 'Comments retrieved successfully',
                ])
                ->response()
                ->setStatusCode(200);
    }
    
    public function store(string $slug, Request $request): JsonResponse
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|integer|exists:comments,id',
        ]);

        $recipe = Recipe::where('slug', $slug)->first();

        $comment = $recipe->comments()->create([
            'user_id' => auth('api')->user()->id,
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        return new CommentResource($comment)->additional([
                    'status' => 'success',
                    'response_code' => 201,
                    'message' => 'Comments submitted successfully',
                ])
                ->response()
                ->setStatusCode(201);
    }

    public function update(Comment $comment, Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        if ($comment->user_id !== auth('api')->user()->id) {
            return response()->json([
                'status' => 'error',
                'response_code' => 403,
                'message' => 'You are not authorized to update this comment.',
                'data' => $comment,
            ], 403);
        }

        $comment->update($validatedData);

        return new CommentResource($comment)->additional([
                    'status' => 'success',
                    'response_code' => 200,
                    'message' => 'Comments updated successfully',
                ])
                ->response()
                ->setStatusCode(200);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        if ($comment->user_id !== auth('api')->user()->id) {
            return response()->json([
                'status' => 'error',
                'response_code' => 403,
                'message' => 'You are not authorized to delete this comment.',
                'data' => $comment,
            ], 403);
        }

        $comment->delete();

        return new CommentResource($comment)->additional([
                    'status' => 'success',
                    'response_code' => 204,
                    'message' => 'Comments deleted successfully',
                ])
                ->response()
                ->setStatusCode(204);
    }
}
