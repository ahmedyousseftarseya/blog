<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('v1')->group(function () {

    // Auth
    Route::controller(AuthController::class)->prefix('auth')->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
    });

});


Route::prefix('v1')->middleware('auth_api')->group(function () {

    // Route::apiResource('/', PostController::class);
    Route::controller(PostController::class)->prefix('posts')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{post}', 'destroy');
    });

     Route::controller(CommentController::class)->prefix('posts')->group(function () {
        Route::get('/{postId}/comments', 'index');
        Route::post('/{postId}/comments', 'store');
        Route::get('/{postId}/comments/{id}', 'show');
        Route::put('/{postId}/comments/{id}', 'update');
        Route::delete('{postId}/comments/{id}', 'destroy');
    });


     Route::controller(ReplyController::class)->prefix('comments')->group(function () {
        Route::get('/{commentId}/replies', 'index');
        Route::post('/{commentId}/replies', 'store');
        Route::get('/{commentId}/replies/{id}', 'show');
        Route::put('/{commentId}/replies/{id}', 'update');
        Route::delete('{commentId}/replies/{id}', 'destroy');
    });

});

