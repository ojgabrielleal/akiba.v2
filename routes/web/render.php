<?php 

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;

use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\DashboardController;

Route::prefix('painel')->group(function () {
    Route::get('/', [AuthController::class, 'render']);

    Route::middleware(AuthMiddleware::class)->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'render']);
    });
});
