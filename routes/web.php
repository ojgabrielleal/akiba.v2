<?php 

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Private\LoginController;
use App\Http\Controllers\Web\Private\AdmsController;
use App\Http\Controllers\Web\Private\BroadcastController;
use App\Http\Controllers\Web\Private\DashboardController;
use App\Http\Controllers\Web\Private\PostController;
use App\Http\Controllers\Web\Private\ReviewController;
use App\Http\Controllers\Web\Private\EventController;
use App\Http\Controllers\Web\Private\RadioController;
use App\Http\Controllers\Web\Private\PodcastsController;
use App\Http\Controllers\Web\Private\MarketingController;
use App\Http\Controllers\Web\Private\MediasController;
use App\Http\Controllers\Web\Private\ProfileController;

/*
|--------------------------------------------------------------------------
| Private routes
|--------------------------------------------------------------------------
*/

Route::prefix('painel')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('', 'render')->name('login');
        Route::post('auth', 'login');
    });
    Route::middleware(['inertia', 'auth'])->group(function () {
        Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {
            Route::get('', 'render')->name('painel.dashboard');
            Route::prefix('activity')->group(function () {
                Route::post('{activity:uuid}/confirm', 'confirmActivityParticipant');
            });
            Route::prefix('task')->group(function () {
                Route::post('{task:uuid}/complete', 'markTaskCompleted');
            });
        });
        Route::prefix('materias')->controller(PostController::class)->group(function () {
            Route::get('', 'render')->name('painel.materias');
            Route::post('', 'createPost');
            Route::patch('{post:uuid}', 'updatePost');
            Route::get('{post:uuid}', 'showPost');
            });
        Route::prefix('reviews')->controller(ReviewController::class)->group(function () {
            Route::get('', 'render')->name('painel.reviews');
            Route::post('', 'createReview');
            Route::patch('{review:uuid}', 'updateReview');
            Route::get('{review:uuid}', 'showReview');
        });
        Route::prefix('eventos')->controller(EventController::class)->group(function () {
            Route::get('', 'render')->name('painel.eventos');
            Route::post('', 'createEvent');
            Route::patch('{event:uuid}', 'updateEvent');
            Route::get('{event:uuid}', 'showEvent');
        });
        Route::prefix('locucao')->controller(BroadcastController::class)->group(function () {
            Route::prefix('broadcast')->group(function () {
                Route::post('start/{program:uuid}', 'startBroadcast');
                Route::post('finish', 'finishBroadcast');
            });
            Route::prefix('song-request')->group(function () {
                Route::post('{songRequest}/played', 'markSongRequestAsPlayed');
                Route::post('status/toggle', 'toggleSongRequestBoxEnabled');
            });
            Route::get('', 'render')->name('painel.locucao');
        });
        Route::prefix('radio')->controller(RadioController::class)->group(function () {
            Route::prefix('program')->group(function () {
                Route::post('', 'createProgram');
                Route::patch('{program}', 'updateProgram');
                Route::get('{program}', 'showProgram');
                Route::delete('{program}', 'deactivateProgram');
            });
            Route::prefix('ranking-music')->group(function () {
                Route::post('', 'generateMusicRanking');
                Route::patch('{music}', 'updateMusicRanking');
            });
            Route::prefix('listener-month')->group(function () {
                Route::post('', 'createListenerMonth');
                Route::get('found', 'showListenerMonthFound');
            });
            Route::get('', 'render')->name('painel.radio');
        });
        Route::prefix('podcasts')->controller(PodcastsController::class)->group(function () {
            Route::get('', 'render')->name('painel.podcasts');
            Route::post('', 'createPodcast');
            Route::patch('{podcast}', 'updatePodcast');
            Route::delete('{podcast}', 'deactivatePodcast');
            Route::get('{podcast:slug}', 'showPodcast');
        });
        Route::prefix('marketing')->controller(MarketingController::class)->group(function () {
            Route::prefix('repository')->group(function () {
                Route::post('', 'createRepository');
                Route::get('{repository}', 'showRepository');
                Route::patch('{repository}', 'updateRepository');
                Route::delete('{repository}', 'deactivateRepository');
            });
            Route::get('', 'render')->name('painel.marketing');
        });
        Route::prefix('medias')->controller(MediasController::class)->group(function () {
            Route::prefix('event')->group(function () {
                Route::delete('{event}', 'deactivateEvent');
            });
            Route::prefix('poll')->group(function () {
                Route::post('', 'createPoll');
                Route::patch('{poll}', 'updatePoll');
                Route::delete('{poll}', 'deactivatePoll');
                Route::get('{poll}', 'showPoll');
                Route::prefix('vote')->group(function () {
                    Route::post('{pollOption}', 'createVote');
                });
            });
            Route::get('', 'render')->name('painel.medias');
        });
        Route::prefix('adms')->controller(AdmsController::class)->group(function () {
            Route::prefix('user')->group(function () {
                Route::post('', 'createUser');
                Route::delete('{user}', 'deactivateUser');
                Route::prefix('password')->group(function () {
                    Route::patch('{user}/update', 'changeUserPassword');
                });
                Route::prefix('roles')->group(function () {
                    Route::patch('{user}/update', 'changeUserRoles');
                });
            });
            Route::get('', 'render')->name('painel.adms');
        });
        Route::prefix('profile')->controller(ProfileController::class)->group(function () {
            Route::patch('{profile}', 'updateProfile');
            Route::get('{profile:slug}', 'render')->name('painel.profile');
        });
    });
});
