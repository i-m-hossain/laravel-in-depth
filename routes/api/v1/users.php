<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'users',
    'middleware' => [
        // 'auth:sanctum',
        // RedirectIfAuthenticated::class
    ],
    'as' => 'users.'
], function () {
    Route::get('/', [UserController::class, 'index'])
        ->name('index');
        // ->withoutMiddleware(['auth:sanctum']);
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::group(
        [
            "where" => ['user', '[0-9]+'],
        ],
        function () {
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::patch('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        }
    );
});
