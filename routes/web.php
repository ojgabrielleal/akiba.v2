<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;

use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\DashboardController;

Route::prefix('painel')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/', 'render')->name('auth.render.painel');
        Route::post('/', 'auth');
    });

    Route::middleware(AuthMiddleware::class)->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard', 'render')->name('dashboard.render.painel');
        });
    });
});
