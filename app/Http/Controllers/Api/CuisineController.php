<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CuisineResource;
use App\Models\Backend\Cuisine;
use Illuminate\Http\Request;

class CuisineController extends Controller
{
    public function list()
    {
        $cuisines  = Cuisine::latest()->get(['id', 'name']);

        return CuisineResource::collection($cuisines)->additional([
                'status' => 'success',
                'response_code' => 200,
                'message' => 'Cuisines retrieved successfully',
            ])
            ->response()
            ->setStatusCode(200);;
    }
}
