<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\CuisineController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\IngredientController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;

Route::group([
    'prefix' => admin_route(),
    'as'     => admin_route_name(),
    'middleware' => 'web',
], function() {

    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
    });
    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout')
        ->middleware('admin.auth');

    Route::middleware('admin.auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, '__invoke'])->name('dashboard');
        Route::resource('admins', AdminController::class);
        Route::resource('roles', RoleController::class);
        Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('users/{user}/update-status', [UserController::class, 'updateStatus'])->name('users.update-status');

        Route::resource('cuisines', CuisineController::class);
        Route::resource('ingredients', IngredientController ::class);
    });

    // Route::get('site-settings', [DashboardController::class, 'settings'])->name('site-settings');
});

