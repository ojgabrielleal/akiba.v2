<?php 

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;

use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\DashboardController;

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::post('/authenticate', [AuthController::class, 'authenticate']);

    Route::controller(DashboardController::class)->group(function () {
        Route::post('/alerts/signature/{alertIdentifier}', 'createAlertSignature');
        Route::patch('/tasks/completed/{taskIdentifier}', 'finishingTask');
    });
});
