<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)
    ->group(function () {
        Route::post('/login', 'login')->name('login');
        Route::prefix('/blog')
            ->group(function () {
                Route::get('posts', [PostController::class, 'index']);
                Route::get('post/{post}', [PostController::class, 'show']);
                Route::post('post/{post}/comment', [PostController::class, 'storeComment']);

                Route::get('categories', [CategoryController::class, 'all']);
            });

        Route::middleware('auth:api')
            ->group(function () {
                Route::get('/info', 'info')->name('info');
                Route::get('/logout', 'logout')->name('logout');

                Route::resource('categories', CategoryController::class);
                Route::resource('posts', PostController::class);

                Route::delete('comments/{comment}', [PostController::class, 'destroyComment']);
            });
    });

