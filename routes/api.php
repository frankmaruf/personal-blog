<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Blog\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group([
    'middleware' => ['json.response'],
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/sign_up', [AuthController::class, 'registration']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::group(['prefix' => 'admin'], function () {
        // Role
        Route::get('/role', [RoleController::class, 'index']);
        Route::post('/role', [RoleController::class, 'store']);
        Route::get('/permission', [PermissionController::class, 'index']);
        Route::post('/permission', [PermissionController::class, 'store']);
        // Permission

        // Clear The Cache
        Route::middleware(["auth", "json.response", "role:super-admin|admin"])->group(function () {
            Route::get('/clear', function () {
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('config:cache');
                Artisan::call('view:clear');
                Artisan::call('route:clear');
                return "Cleared!";
            });
        });
    });
    // Post
    Route::group([
        'prefix' => 'blog'
    ], function () {
        Route::get('posts', [BlogController::class, 'index']);
        Route::get('posts/{id}', [BlogController::class, 'show'])->middleware("auth_optional:api");
        Route::get('posts/{slug}', [BlogController::class, 'showBySlug']);
        Route::post('posts/', [BlogController::class, 'store']);
        Route::patch('posts/{id}', [BlogController::class, 'update']);
        Route::post('posts/{id}', [BlogController::class, 'delete']);
    });
});
