<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RoleController;

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
        Route::get('/', function(){
            return inertia('Home');
        });

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Route::get('site-settings', [DashboardController::class, 'settings'])->name('site-settings');

    // Route::resource('roles', RoleController::class);
    // Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

    // Route::resource('admins', AdminController::class);
});

Route::get('/', function () {
    return Inertia::render('Home');
});
