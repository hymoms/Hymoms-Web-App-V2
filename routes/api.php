<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'getAll']);
    Route::get('/{id}', [UserController::class, 'getOne']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('follower')->group(function () {
    Route::get('/', [FollowerController::class, 'getAll']);
    Route::get('/{id}', [FollowerController::class, 'getOneUserFollowing']);
    Route::post('/', [FollowerController::class, 'store']);
    Route::delete('/{id}', [FollowerController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('content')->group(function () {
    // post route
    Route::get('/post', [PostController::class, 'getAllPost']);
    Route::get('/post{id}', [PostController::class, 'getOnePost']);
    Route::post('/post', [PostController::class, 'createPost']);
    Route::put('/post{id}', [PostController::class, 'updatePost']);
    Route::delete('/post{id}', [PostController::class, 'deletePost']);
    
    // like route
    Route::post('/like', [PostController::class, 'addLike']);
    Route::delete('/like/{id}', [PostController::class, 'deleteLike']);
    
    // comment route
    Route::post('/comment', [PostController::class, 'addComment']);
    Route::put('/comment/{id}', [PostController::class, 'updateComment']);
    Route::delete('/comment/{id}', [PostController::class, 'deleteComment']);


});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/login_first', [AuthController::class, 'login_first'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');;
});


