<?php

use App\Http\Controllers\CommentController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'comments',
    'middleware' => [
        // 'auth:sanctum',
        // RedirectIfAuthenticated::class
    ],
    'as' => 'comments.'
], function () {
    Route::get('/', [CommentController::class, 'index'])
        ->name('index');
        // ->withoutMiddleware('auth.sanctum');
    Route::post('/', [CommentController::class, 'store'])->name('store');
    Route::group(
        [
            "where" => ['comment', '[0-9]+'],
        ],
        function () {
            Route::get('/{comment}', [CommentController::class, 'show'])->name('show');
            Route::patch('/{comment}', [CommentController::class, 'update'])->name('update');
            Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');
        }
    );
});
