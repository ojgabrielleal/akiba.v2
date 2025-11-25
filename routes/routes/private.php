<?php 
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Private\DashboardController;
use App\Http\Controllers\Web\Private\PostsController;
use App\Http\Controllers\Web\Private\ReviewsController;
use App\Http\Controllers\Web\Private\EventsController;
use App\Http\Controllers\Web\Private\RadioController;
use App\Http\Controllers\Web\Private\PodcastsController;
use App\Http\Controllers\Web\Private\MarketingController;
use App\Http\Controllers\Web\Private\MediasController;
use App\Http\Controllers\Web\Private\ProfileController;

// Controllers - Login Module
use App\Http\Controllers\Web\Private\Login\LoginController;

// Controllers - Adms Module
use App\Http\Controllers\Web\Private\Administrator\AdministratorController;
use App\Http\Controllers\Web\Private\Administrator\UserController as AdministratorUserController;

// Controllers - Onair Module
use App\Http\Controllers\Web\Private\Onair\OnairController;
use App\Http\Controllers\Web\Private\Onair\Modules\BroadcastController as OnairBroadcastController;
use App\Models\SongRequest;

Route::prefix('painel')->group(function () {
    Route::controller(LoginController::class)->group(function () {
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
            Route::get('/', [OnairController::class, 'render'])->name('render.painel.locucao');
            Route::prefix('/broadcast')->group(function () {
                Route::controller(OnairBroadcastController::class)->group(function () {
                    Route::post('/start', 'startBroadcast');
                    Route::post('/finish', 'finishBroadcast');
                });
            });
            Route::prefix('/song-request')->group(function () {
                Route::controller(SongRequest::class)->group(function () {
                    Route::post('/set/played/{songRequestId}', 'setIsPlayed');
                    Route::post('/toggle/status', 'toggleStatus');
                });
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
            Route::get('/', [AdministratorController::class, 'render'])->name('render.painel.adms');
            Route::prefix('/users')->group(function(){
                Route::controller(AdministratorUserController::class)->group(function () {
                    Route::post('/create', 'createUser');
                    Route::put('/update/{id}', 'updateUser');
                    Route::put('/update/password/{id}', 'updateUserPassword');
                    Route::delete('/deactivate/{id}', 'deactivateUser');
                });
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