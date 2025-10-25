<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\PostsController;
use App\Http\Controllers\Web\Admin\ReviewsController;
use App\Http\Controllers\Web\Admin\EventsController;
use App\Http\Controllers\Web\Admin\BroadcastController;
use App\Http\Controllers\Web\Admin\RadioController;
use App\Http\Controllers\Web\Admin\PodcastsController;
use App\Http\Controllers\Web\Admin\MarketingController;
use App\Http\Controllers\Web\Admin\MediasController;

use App\Http\Controllers\Web\Public\HomeProvisoryController;

Route::prefix('/')->group(function () {
    Route::controller(HomeProvisoryController::class)->group(function () {
        Route::get('/', 'render')->name('render.public.home');
        Route::post('/create/listener/request', 'createListenerRequest');
    });
});

Route::prefix('painel')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/', 'render')->name('render.painel.auth');
        Route::post('/authenticate', 'authenticate');
    });

    Route::middleware(['inertia', 'auth'])->group(function () {
        Route::prefix('/dashboard')->group(function () {
            Route::controller(DashboardController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.dashboard');
                Route::post('/alerts/{id}', 'createAlertSignature');
                Route::patch('/tasks/{id}', 'setTaskCompleted');
            });
        });
        Route::prefix('/materias')->group(function () {
            Route::controller(PostsController::class)->group(function () {
                Route::get('/{slug?}', 'render')->name('render.painel.materias');
                Route::post('/create', 'createPost');
                Route::post('/update/{id}', 'updatePost');
            });
        });
        Route::prefix('/reviews')->group(function () {
            Route::controller(ReviewsController::class)->group(function () {
                Route::get('/{slug?}', 'render')->name('render.painel.reviews');
                Route::post('/create', 'createReview');
                Route::post('/update/{id}', 'updateReview');
            });
        });
        Route::prefix('/eventos')->group(function () {
            Route::controller(EventsController::class)->group(function () {
                Route::get('/{slug?}', 'render')->name('render.painel.eventos');
                Route::post('/create', 'createEvent');
                Route::post('/update/{id}', 'updateEvent');
            });
        });
        Route::prefix('/locucao')->group(function () {
            Route::controller(BroadcastController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.locucao');
                Route::get('/requests', 'getListenerRequests');
                Route::patch('/requests/status', 'setListenerRequestsStatus');
                Route::patch('/requests/attended/{id}', 'setToAttendedListenerRequest');
                Route::patch('/requests/canceled/{id}', 'setCancelListenerRequest');
                Route::post('/broadcast/start', 'setStartBroadcast');
                Route::post('/broadcast/end', 'setEndBroadcast');
            });
        });
        Route::prefix('/radio')->group(function () {
            Route::controller(RadioController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.radio');
                Route::get('/get/show/{id}', 'getShow');
                Route::post('/create/show', 'createShow');
                Route::post('/update/show/{id}', 'updateShow');
                Route::patch('/deactivate/show/{id}', 'deactivateShow');
                Route::post('/update/ranking/image/{id}', 'updateRankingMusicImage');
                Route::post('/create/ranking', 'setRankingMusic');
                Route::post('/create/listenermonth', 'createListenerMonth');
            });
        });
        Route::prefix('/podcasts')->group(function () {
            Route::controller(PodcastsController::class)->group(function () {
                Route::get('/{slug?}', 'render')->name('render.painel.podcasts');
                Route::post('/create', 'createPodcast');
                Route::post('/update/{id}', 'updatePodcast');
                Route::patch('/deactivate/{id}', 'deactivatePodcast');
            });
        });
        Route::prefix('/marketing')->group(function () {
            Route::controller(MarketingController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.marketing');
                Route::get('/get/repository/{id?}', 'getRepository');
                Route::post('/create/repository', 'createRepository');
                Route::post('/update/repository/{id}', 'updateRepository');
                Route::patch('/deactivate/repository/{id}', 'deactivateRepository');
            });
        });
        Route::prefix('/medias')->group(function () {
            Route::controller(MediasController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.medias');
                Route::get('/get/poll/{id}', 'getPoll');
                Route::post('/create/poll', 'createPoll');
                Route::patch('/update/poll/{id}', 'updatePoll');
                Route::post('/create/vote/{id}', 'createVote');
                Route::patch('/deactivate/poll/{id}', 'deactivatePoll');
                Route::patch('/deactivate/event/{slug}', 'deactivateEvent');
            });
        });
    });
});
