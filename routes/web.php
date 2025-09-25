<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\PostsController;
use App\Http\Controllers\Web\Admin\ReviewsController;
use App\Http\Controllers\Web\Admin\EventsController;
use App\Http\Controllers\Web\Admin\Stream;

Route::prefix('painel')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/', 'render')->name('render.painel.auth');
        Route::post('/authenticate', 'authenticate');
    });

    Route::middleware(['inertia', 'auth'])->group(function () {
        Route::prefix('/dashboard')->group(function () {
            Route::controller(DashboardController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.dashboard');
                Route::post('/alerts/{alertId}', 'createAlertSignature');
                Route::patch('/tasks/{taskId}', 'setTaskCompleted');
            });
        });
        Route::prefix('/materias')->group(function () {
            Route::controller(PostsController::class)->group(function () {
                Route::get('/{slug?}', 'render')->name('render.painel.materias');
                Route::post('/update/{slug}', 'updatePost');
                Route::post('/create', 'createPost');
            });
        });
        Route::prefix('/reviews')->group(function () {
            Route::controller(ReviewsController::class)->group(function () {
                Route::get('/{slug?}', 'render')->name('render.painel.reviews');
                Route::post('/create', 'createReview');
                Route::post('/update/{slug}', 'updateReview');
            });
        });
        Route::prefix('/eventos')->group(function () {
            Route::controller(EventsController::class)->group(function () {
                Route::get('/{slug?}', 'render')->name('render.painel.eventos');
                Route::post('/create', 'createEvent');
                Route::post('/update/{slug}', 'updateEvent');
            });
        });
        Route::prefix('/locucao')->group(function () {
            Route::controller(Stream::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.locucao');
                Route::patch('/listenerrequeststatus/{status}', 'setListenerRequestsStatus');
                Route::post('/startbroadcast/{show}', 'setStartBroadcast');
                Route::post('/endbroadcast', 'setEndBroadcast');
            });
        });
    });
});
