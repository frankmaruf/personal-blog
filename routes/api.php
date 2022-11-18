<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\User\UserController;
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

        Route::get('/roles', [RoleController::class, 'index'])->middleware("role:super-admin|admin", 'auth:api', 'verified:api');
        Route::post('/roles', [RoleController::class, 'store']);
        Route::get('/roles/{id}', [RoleController::class, 'show']);
        Route::put('/roles/{id}', [RoleController::class, 'update']);
        Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

        // Permission

        Route::get('/permissions', [PermissionController::class, 'index'])->middleware("role:super-admin|admin", 'auth:api', 'verified:api',);
        Route::post('/permissions', [PermissionController::class, 'store']);
        Route::get('/permissions/{id}', [PermissionController::class, 'show']);
        Route::put('/permissions/{id}', [PermissionController::class, 'update']);
        Route::delete('/permissions/{id}', [PermissionController::class, 'update']);

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
        Route::get('latest', [BlogController::class, 'latestPost']);
        Route::get('top', [BlogController::class, 'topPost']);
        Route::get('posts/{id}', [BlogController::class, 'show'])->middleware("auth_optional:api");
        Route::get('posts/{slug}', [BlogController::class, 'showBySlug'])->middleware("auth_optional:api");
        Route::post('posts/', [BlogController::class, 'store']);
        Route::patch('posts/{id}', [BlogController::class, 'update']);
        Route::post('posts/{id}', [BlogController::class, 'delete']);
    });
    // Users
    Route::group([
        'prefix' => 'users'
    ], function () {
        Route::get('', [UserController::class, 'index']);
        Route::get('{id}', [UserController::class, 'show'])->middleware("auth_optional:api");
        Route::put('{id}', [UserController::class, 'show'])->middleware("auth_optional:api");
        Route::delete('{id}', [UserController::class, 'show'])->middleware("auth_optional:api");
        Route::get('{id}/posts/', [UserController::class, 'showUserPost']);
    });
});
    
