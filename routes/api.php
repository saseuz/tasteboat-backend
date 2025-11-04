<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeCommentController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\RecipeFavouriteController;
use App\Http\Controllers\Api\RecipeRatingController;
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
    Route::post('/recipes', [RecipeController::class, 'store']);

    // Favourite recipes
    Route::get('/favourite-recipes', [RecipeFavouriteController::class, 'favouriteRecipes']);
    Route::post('/recipes/{slug}/favourite', [RecipeFavouriteController::class, 'favouriteToggle']);

    // Rating routes
    Route::post('/recipes/{slug}/rating', [RecipeRatingController::class, 'store']);

    // Comment routes
    Route::post('/recipes/{slug}/comments', [RecipeCommentController::class, 'store']);

});

// Public recipe routes
Route::get('/recipes', [RecipeController::class, 'list']);
Route::get('/recipes/{slug}', [RecipeController::class, 'detail']);