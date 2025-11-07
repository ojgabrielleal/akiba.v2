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
use App\Http\Controllers\Web\Admin\AdmsController;
use App\Http\Controllers\Web\Admin\ProfileController;

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

    Route::middleware(['inertiaMiddleware', 'authMiddleware'])->group(function () {
        Route::prefix('/dashboard')->group(function () {
            Route::controller(DashboardController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.dashboard');
                Route::post('/create/alert/signature/{id}', 'createAlertSignature');
                Route::put('/set/complete/task/{id}', 'setTaskComplete');
            });
        });
        Route::prefix('/materias')->group(function () {
            Route::controller(PostsController::class)->group(function () {
                Route::get('/{slug?}', 'render')->name('render.painel.materias');
                Route::post('/create', 'createPost');
                Route::put('/update/{id}', 'updatePost'); 
            });
        });
        Route::prefix('/reviews')->group(function () {
            Route::controller(ReviewsController::class)->group(function () {
                Route::get('/{slug?}', 'render')->name('render.painel.reviews');
                Route::post('/create', 'createReview');
                Route::put('/update/{id}', 'updateReview');
            });
        });
        Route::prefix('/eventos')->group(function () {
            Route::controller(EventsController::class)->group(function () {
                Route::get('/{slug?}', 'render')->name('render.painel.eventos');
                Route::post('/create', 'createEvent');
                Route::put('/update/{id}', 'updateEvent');
            });
        });
        Route::prefix('/locucao')->group(function () {
            Route::controller(BroadcastController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.locucao');
                Route::put('/set/status/listener/requests', 'setChangeListenerRequestsStatus');
                Route::put('/set/granted/listener/requests/{id}', 'setGrantedListenerRequest');
                Route::put('/set/cancel/listener/requests/{id}', 'setCancelListenerRequest');
                Route::post('/set/start/broadcast', 'setStartBroadcast');
                Route::post('/set/finish/broadcast', 'setFinishBroadcast');
            });
        });
        Route::prefix('/radio')->group(function () {
            Route::controller(RadioController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.radio');
                Route::get('/get/show/{id}', 'getShow');
                Route::post('/create/show', 'createShow');
                Route::put('/update/show/{id}', 'updateShow');
                Route::delete('/deactivate/show/{id}', 'deactivateShow');
                Route::post('/update/ranking/image/{id}', 'updateRankingMusicImage');
                Route::post('/create/ranking', 'setRankingMusic');
                Route::post('/create/listener/month', 'createListenerMonth');
            });
        });
        Route::prefix('/podcasts')->group(function () {
            Route::controller(PodcastsController::class)->group(function () {
                Route::get('/{slug?}', 'render')->name('render.painel.podcasts');
                Route::post('/create', 'createPodcast');
                Route::put('/update/{id}', 'updatePodcast');
                Route::delete('/deactivate/{id}', 'deactivatePodcast');
            });
        });
        Route::prefix('/marketing')->group(function () {
            Route::controller(MarketingController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.marketing');
                Route::get('/get/repository/{id}', 'getRepository');
                Route::post('/create/repository', 'createRepository');
                Route::put('/update/repository/{id}', 'updateRepository');
                Route::delete('/deactivate/repository/{id}', 'deactivateRepository');
            });
        });
        Route::prefix('/medias')->group(function () {
            Route::controller(MediasController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.medias');
                Route::get('/get/poll/{id}', 'getPoll');
                Route::post('/create/poll', 'createPoll');
                Route::put('/update/poll/{id}', 'updatePoll');
                Route::post('/create/vote/{id}', 'createVote');
                Route::delete('/deactivate/poll/{id}', 'deactivatePoll');
                Route::delete('/deactivate/event/{id}', 'deactivateEvent');
            });
        });
        Route::prefix('/adms')->group(function () {
            Route::controller(AdmsController::class)->group(function () {
                Route::get('/', 'render')->name('render.painel.adms');
                Route::get('/get/user/{id}', 'getUser');
                Route::post('/create/user', 'createUser');
                Route::put('/update/user/permissions/{id}', 'updateUserPermissions');
                Route::put('/update/user/password/{id}', 'updateUserPassword');
                Route::delete('/deactivate/user/{id}', 'deativateUser');
            });
        });
        Route::prefix('/profile')->group(function () {
            Route::controller(ProfileController::class)->group(function () {
                Route::get('/{slug?}', 'render')->name('render.painel.profile');
                Route::put('/update/{id}', 'updateUser');
            });
        });
    });
});
