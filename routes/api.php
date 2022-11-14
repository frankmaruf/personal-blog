<?php

use App\Http\Controllers\BlogController;
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

Route::get('posts', [BlogController::class, 'index']);
Route::get('posts/{id}', [BlogController::class, 'show'])->middleware("auth_optional:api");
Route::get('posts/{slug}', [BlogController::class, 'showBySlug']);
Route::post('posts/', [BlogController::class, 'store']);
Route::patch('posts/{id}', [BlogController::class, 'update']);
Route::post('posts/{id}', [BlogController::class, 'delete']);

Route::group([
    'middleware' => ['json.response'],
], function () {
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/sign_up', [\App\Http\Controllers\AuthController::class, 'registration']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('/refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    Route::get('/me', [\App\Http\Controllers\AuthController::class, 'me']);
    Route::get('/role', [\App\Http\Controllers\RolePermissionController::class, 'index']);
});


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
