<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Admin\Authenticate;
use App\Http\Controllers\Web\Admin\Dashboard;

Route::prefix('painel')->group(function () {
    Route::controller(Authenticate::class)->group(function () {
        Route::get('/', 'render');
        Route::post('/', 'auth');
    });

    Route::controller(Dashboard::class)->group(function () {
        Route::get('/dashboard', 'render');
    });
});
