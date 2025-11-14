<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Backend\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function list()
    {
        $categories = Category::latest()->get();
        return CategoryResource::collection($categories)->additional([
                'status' => 'success',
                'response_code' => 200,
                'message' => 'Categories retrieved successfully',
            ])
            ->response()
            ->setStatusCode(200);
    }
}
