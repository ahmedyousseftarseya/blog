<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
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

    // Auth
    Route::controller(PostController::class)->prefix('posts')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{post}', 'destroy');
    });


     // Auth
     Route::controller(CommentController::class)->prefix('posts')->group(function () {
        Route::get('/{postId}/comments', 'index');
        Route::post('/{postId}/comments', 'store');
        Route::get('/{postId}/comments/{id}', 'show');
        Route::put('/{postId}/comments/{id}', 'update');
        Route::delete('{postId}/comments/{id}', 'destroy');
    });


});

