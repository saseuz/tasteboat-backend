<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refreshToken']);

Route::group(['middleware' => ['auth:api']], function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // User profile
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('user/update-profile', [UserController::class, 'updateProfile']);

    // Create new recipe 
    Route::post('/recipes', [RecipeController::class, 'create']);

    // Favourite recipes
    Route::get('/favourite-recipes', [RecipeController::class, 'favouriteRecipes']);
    Route::post('/recipes/{slug}/favourite', [RecipeController::class, 'favouriteToggle']);

    // Rating routes
    Route::post('/recipes/{slug}/rating', [RecipeController::class, 'ratingSubmit']);

});

// Public recipe routes
Route::get('/recipes', [RecipeController::class, 'list']);
Route::get('/recipes/{slug}', [RecipeController::class, 'detail']);