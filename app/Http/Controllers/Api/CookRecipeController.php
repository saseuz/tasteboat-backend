<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CookRecipeResource;
use App\Models\User;
use Illuminate\Http\Request;

class CookRecipeController extends Controller
{
    public function topList(Request $request)
    {
        $cooks = User::query()
            ->when($request->has('limit'), function ($q) use ($request) {
                $q->limit($request->limit);
            })
            ->has('recipes')
            ->withAvg('ratings', 'rating')
            ->withCount('recipes')
            ->orderByDesc('ratings_avg_rating')
            ->get();

        return CookRecipeResource::collection($cooks)->additional([
            'status' => 'success',
            'response_code' => 200,
            'message' => 'Top cooks retrieved successfully',
        ])
            ->response()
            ->setStatusCode(200);
    }
}
