<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CuisineController;
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

    // Private recipe routes 
    Route::get('/recipes/my-recipes', [RecipeController::class, 'myRecipes']);
    Route::post('/recipes', [RecipeController::class, 'store']);
    Route::post('/recipes/{slug}/update', [RecipeController::class, 'update']);
    Route::delete('/recipes/{slug}/delete', [RecipeController::class, 'destroy']);

    // Favourite recipes routes
    Route::get('/favourite-recipes', [RecipeFavouriteController::class, 'favouriteRecipes']);
    Route::post('/recipes/{slug}/favourite', [RecipeFavouriteController::class, 'favouriteToggle']);

    // Rating routes
    Route::post('/recipes/{slug}/rating', [RecipeRatingController::class, 'store']);

    // Comment routes
    Route::post('/recipes/{slug}/comments', [RecipeCommentController::class, 'store']);
    Route::put('/comments/{comment}/update', [RecipeCommentController::class, 'update']);
    Route::delete('/comments/{comment}/delete', [RecipeCommentController::class, 'destroy']);

    // Cuisine routes
    Route::get('cuisines/all', [CuisineController::class, 'list']);

});

// Public recipe routes
Route::get('/recipes', [RecipeController::class, 'list']);
Route::get('/recipes/{slug}/detail', [RecipeController::class, 'detail']);

// Public comment routes
Route::get('/recipes/{slug}/comments', [RecipeCommentController::class, 'commentsByRecipe']);

// Public categroy routes
Route::get('categories/all', [CategoryController::class, 'list']);
