<?php

use App\Http\Controllers\PostController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'posts',
    'middleware' => [
        // 'auth:sanctum',
        // RedirectIfAuthenticated::class
    ],
    'as' => 'posts.'
], function () {
    Route::get('/', [PostController::class, 'index'])
        ->name('index');
        // ->withoutMiddleware('auth.sanctum');
    Route::post('/', [PostController::class, 'store'])
        ->name('store');
    Route::group([
            "where" => ['post', '[0-9]+'],
        ],
        function () {
            Route::get('/{post}', [PostController::class, 'show'])->name('show');
            Route::patch('/{post}', [PostController::class, 'update'])->name('update');
            Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
            Route::post('/{post}/share', [PostController::class, 'share'])->name('share');
        }
    );
});
