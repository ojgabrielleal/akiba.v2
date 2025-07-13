<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;

use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\PostsController;

Route::prefix('painel')->group(function(){
    Route::controller(AuthController::class)->group(function () {
        Route::get('/', 'render')->name('render.painel.auth');
        Route::post('/authenticate', 'authenticate');
    });

    Route::middleware([AuthMiddleware::class])->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard', 'render')->name('render.painel.dashboard');
            Route::post('/alerts/signature/{alertIdentifier}', 'createAlertSignature');
            Route::patch('/tasks/completed/{taskIdentifier}', 'finishingTask');
        });
        Route::controller(PostsController::class)->group(function () {
            Route::get('/posts', 'render')->name('render.painel.posts');
        });
    });
});
