<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\HandleLaravelAuth;

use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\PostsController;

Route::prefix('painel')->group(function(){
    Route::controller(AuthController::class)->group(function () {
        Route::get('/', 'render')->name('render.painel.auth');
        Route::post('/authenticate', 'authenticate');
    });

    Route::middleware(['auth', 'inertia'])->group(function () {
        
        Route::prefix('/dashboard')->group(function(){
            Route::controller(DashboardController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.dashboard');
                Route::post('/alerts/{alertId}', 'createAlertSignature');
                Route::patch('/tasks/{taskId}', 'completeTask');
            });
        });

        Route::prefix('/materias')->group(function(){
            Route::controller(PostsController::class)->group(function () {
                Route::get('/{postSlug?}', 'render')->name('render.painel.materias');
                Route::post('/update/{postSlug}', 'updatePost');
            });
        });
    });
});

