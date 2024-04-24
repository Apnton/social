<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Chat\ChatController;
use App\Http\Controllers\Api\Post\PostController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('registration', [AuthController::class, 'signUp']);
    Route::post('login', [AuthController::class, 'signIn']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('profile', [UserController::class, 'getProfile']);
        Route::get('list', [UserController::class, 'getAllUsers']);
        Route::get('{id}/toggle-following', [UserController::class, 'toggleFollowing']);
        Route::get('{id}/posts', [UserController::class, 'getUserPosts']);
        Route::get('{id}/statistic', [UserController::class, 'getStatistic']);
        Route::get('count-notifications', [UserController::class, 'getCountUnread']);
        Route::get('notifications', [UserController::class, 'getNotifications']);

    });

    Route::prefix('posts')->group(function () {
        Route::get('index', [PostController::class, 'index']);
        Route::post('store', [PostController::class, 'store']);
        Route::get('following-posts', [PostController::class, 'getFollowingPosts']);
        Route::post('{id}/toggle-like', [PostController::class, 'toggleLike']);
        Route::post('repost', [PostController::class, 'repost']);
        Route::post('comment', [PostController::class, 'storeComment']);
        Route::get('{id}/comment', [PostController::class, 'getCommentsByPostId']);
    });

    Route::prefix('chats')->group(function () {
        Route::post('store-chat', [ChatController::class, 'storeChat']);
        Route::post('store-message', [ChatController::class, 'storeMessage']);
        Route::get('{chatId}/messages', [ChatController::class, 'getMessagesByChatId']);
    });
});

Route::get('test', function (\Illuminate\Http\Request $request) {
    dd($request->all());

});



