<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Admin\Authenticate;

Route::prefix('painel')->group(function () {
    Route::prefix('/')->group(function(){
        Route::get('/', [Authenticate::class, 'render']);
        Route::post('/auth', [Authenticate::class, 'auth']);
    });
});
