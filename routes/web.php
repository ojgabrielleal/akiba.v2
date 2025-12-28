<?php 
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Private\LoginController;
use App\Http\Controllers\Web\Private\AdmsController;
use App\Http\Controllers\Web\Private\OnairController;
use App\Http\Controllers\Web\Private\DashboardController;
use App\Http\Controllers\Web\Private\PostsController;
use App\Http\Controllers\Web\Private\ReviewsController;
use App\Http\Controllers\Web\Private\EventsController;
use App\Http\Controllers\Web\Private\RadioController;
use App\Http\Controllers\Web\Private\PodcastsController;
use App\Http\Controllers\Web\Private\MarketingController;
use App\Http\Controllers\Web\Private\MediasController;
use App\Http\Controllers\Web\Private\ProfileController;


/**
 * Redirects
 * These routes are used to redirect old URLs to new ones.
 */
Route::redirect('/login', '/painel', 301);


/**
 * Public routes
 * These routes are open for public access.
 */


/**
 * Private routes
 * These routes are used for administrative functions. 
 */
Route::prefix('painel')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/', 'render')->name('render.painel.login');
        Route::post('/', 'login');
    });
    Route::middleware(['inertia', 'auth'])->group(function () {
        Route::prefix('dashboard')->group(function () {
            Route::controller(DashboardController::class)->group(function () {
                Route::prefix('activity')->group(function(){
                    Route::post('confirm/{activityId}', 'createActivityConfirmation');
                });
                Route::prefix('task')->group(function(){
                    Route::post('complete/{taskId}', 'setTaskCompleted');
                });
                Route::get('/', 'render')->name('render.painel.dashboard');
            });
        });
        Route::prefix('materias')->group(function () {
            Route::controller(PostsController::class)->group(function () {
                Route::post('/', 'createPost');
                Route::put('{postId}', 'updatePost'); 
                Route::get('{postSlug?}', 'render')->name('render.painel.materias');
            });
        });
        Route::prefix('reviews')->group(function () {
            Route::controller(ReviewsController::class)->group(function () {
                Route::post('/', 'createReview');
                Route::put('{reviewsId}', 'updateReview');
                Route::get('{reviewSlug?}', 'render')->name('render.painel.reviews');
            });
        });
        Route::prefix('eventos')->group(function () {
            Route::controller(EventsController::class)->group(function () {
                Route::post('/', 'createEvent');
                Route::put('{eventId}', 'updateEvent');
                Route::get('{eventSlug?}', 'render')->name('render.painel.eventos');
            });
        });
        Route::prefix('locucao')->group(function(){
            Route::controller(OnairController::class)->group(function(){
                Route::prefix('broadcast')->group(function(){
                    Route::post('start', 'startBroadcast');
                    Route::post('finish', 'finishBroadcast');
                });
                Route::prefix('song-request')->group(function(){
                    Route::post('play/{songRequestId}', 'setSongRequestIsPlayed');
                    Route::post('toggle/status', 'toggleSongRequestBoxStatus');
                });
                Route::get('/', 'render')->name('render.painel.locucao');
            });
        });
        Route::prefix('radio')->group(function () {
            Route::controller(RadioController::class)->group(function () {
                Route::prefix('show')->group(function(){
                    Route::post('/', 'createShow');
                    Route::put('{showIid}', 'updateShow');
                    Route::get('{showId}', 'getShow');
                    Route::delete('/{showId}', 'deactivateShow');
                });
                Route::prefix('music-ranking')->group(function(){
                    Route::post('/', 'setRankingMusic');
                    Route::post('image/{musicId}', 'updateRankingMusicImage');
                });
                Route::prefix('listener-month')->group(function(){
                    Route::post('/', 'createListenerMonth');
                });
                Route::get('/', 'render')->name('render.painel.radio');
            });
        });
        Route::prefix('podcasts')->group(function () {
            Route::controller(PodcastsController::class)->group(function () {
                Route::post('/', 'createPodcast');
                Route::put('{podcastId}', 'updatePodcast');
                Route::delete('{podcastId}', 'deactivatePodcast');
                Route::get('{podcastSlug?}', 'render')->name('render.painel.podcasts');
            });
        });
        Route::prefix('marketing')->group(function () {
            Route::controller(MarketingController::class)->group(function () {
                Route::prefix('repository')->group(function(){
                    Route::post('/', 'createRepository');
                    Route::get('{repositoryId}', 'getRepository');
                    Route::put('{repositoryId}', 'updateRepository');
                    Route::delete('{repositoryId}', 'deactivateRepository');
                });
                Route::get('/', 'render')->name('render.painel.marketing');
            });
        });
        Route::prefix('medias')->group(function () {
            Route::controller(MediasController::class)->group(function () {
                Route::prefix('event')->group(function(){
                    Route::delete('{eventId}', 'deactivateEvent');
                });
                Route::prefix('poll')->group(function(){
                    Route::post('/', 'createPoll');
                    Route::put('{pollId}', 'updatePoll');
                    Route::get('{pollId}', 'getPoll');
                    Route::delete('{pollId}', 'deactivatePoll');
                    Route::post('vote/{pollOptionId}', 'createVote');
                });
                Route::get('/', 'render')->name('render.painel.medias');
            });
        });
        Route::prefix('adms')->group(function() {
            Route::controller(AdmsController::class)->group(function () {
                Route::prefix('/user')->group(function(){
                    Route::post('/', 'createUser');
                    Route::put('{userId}', 'updateUser');
                    Route::delete('{userId}', 'deactivateUser');
                    Route::put('pass/{userId}/', 'updateUserPassword');
                });
                Route::get('/', 'render')->name('render.painel.adms');
            });
        });
        Route::prefix('profile')->group(function () {
            Route::controller(ProfileController::class)->group(function () {
                Route::put('{profileId}', 'updateUser');
                Route::get('{profileSlug?}', 'render')->name('render.painel.profile');
            });
        });
    });
});