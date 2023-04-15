<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\User\UserController;
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

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::get('me/posts', [BlogController::class, 'authUserPost']);
    });
    Route::group(['prefix' => 'admin'], function () {

        // Role
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index'])->middleware("role:super-admin|admin", 'auth:api', 'verified:api');
            Route::post('/', [RoleController::class, 'store']);
            Route::get('/{id}', [RoleController::class, 'show']);
            Route::put('/{id}', [RoleController::class, 'update']);
            Route::delete('/{id}', [RoleController::class, 'destroy']);
        });

        // Permission
        Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', [PermissionController::class, 'index'])->middleware("role:super-admin|admin", 'auth:api', 'verified:api',);
            Route::post('/', [PermissionController::class, 'store']);
            Route::get('/{id}', [PermissionController::class, 'show']);
            Route::put('/{id}', [PermissionController::class, 'update']);
            Route::delete('/{id}', [PermissionController::class, 'update']);
        });

        // Analytics
        Route::group(['prefix' => 'analytics'], function () {
            Route::get("", [\App\Http\Controllers\Admin\AnalyticsController::class, "index"]);
            Route::get("top-blog", [\App\Http\Controllers\Admin\AnalyticsController::class, "topContent"]);
            Route::get("top-browser", [\App\Http\Controllers\Admin\AnalyticsController::class, "topBrowser"]);
            Route::get("mobile-traffic", [\App\Http\Controllers\Admin\AnalyticsController::class, "mobileTraffic"]);
            Route::get("organic-search", [\App\Http\Controllers\Admin\AnalyticsController::class, "organicSearch"]);
            Route::get("key-words", [\App\Http\Controllers\Admin\AnalyticsController::class, "keyWords"]);
        });

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
    // Blog
    Route::group([
        'prefix' => 'blog'
    ], function () {
        Route::get('latest', [BlogController::class, 'latestPost']);
        Route::get('top', [BlogController::class, 'topPost']);
        // Blog->Posts
        Route::group(['prefix' => 'posts'], function () {
            Route::post('', [BlogController::class, 'store']);
            Route::patch('/{id}', [BlogController::class, 'update']);
            Route::delete('/{id}', [BlogController::class, 'delete']);
            // middleware
            Route::group(['middleware' => 'auth_optional:api'], function () {
                Route::get('', [BlogController::class, 'index']);
                Route::get('/{id}', [BlogController::class, 'show']);
                Route::get('/{slug}', [BlogController::class, 'showBySlug']);
            });
        });
    });
    // Projects
    Route::group([
        'prefix' => 'projects'
    ], function () {
        Route::get('latest', [ProjectController::class, 'latestPost']);
        Route::get('top', [ProjectController::class, 'topPost']);
            Route::post('', [ProjectController::class, 'store']);
            Route::patch('/{id}', [ProjectController::class, 'update']);
            Route::delete('/{id}', [ProjectController::class, 'delete']);
            Route::get('/managers', [ProjectController::class, 'managers']);
            Route::get('/{id}', [ProjectController::class, 'show']);
            // middleware
            Route::group(['middleware' => 'auth_optional:api'], function () {
                Route::get('', [ProjectController::class, 'index']);
            });
    });
    // Category
    Route::group([
        'prefix' => 'categories'
    ], function () {
        Route::get('', [CategoryController::class, 'index']);
        Route::get('{id}', [CategoryController::class, 'show']);
        Route::get('{id}/posts', [CategoryController::class, 'categoryPost']);
    });
    // Users
    Route::group([
        'prefix' => 'users'
    ], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}/posts/', [UserController::class, 'showUserPost']);
        // middleware
        Route::group(['middleware' => 'auth_optional:api'], function () {
            Route::get('/{id}', [UserController::class, 'show']);
            Route::put('/{id}', [UserController::class, 'show']);
            Route::delete('/{id}', [UserController::class, 'show']);
        });
    });
});
