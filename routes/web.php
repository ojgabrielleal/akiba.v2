<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;

use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\DashboardController;

Route::prefix('painel')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/', 'render');
        Route::post('/', 'authenticate');
    });

    Route::middleware(AuthMiddleware::class)->group(function () {
        Route::prefix('dashboard')->group(function() {
            Route::controller(DashboardController::class)->group(function () {
                Route::get('/', 'render')->name('dashboard.render.painel');
                Route::post('/alerts/signature/{alertIdentifier}', 'createAlertSignature');
            });
        });
    });
});
