<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CastController;

Route::group(['prefix' => 'cast'], function () {
    Route::controller(CastController::class)->group(function () {
        Route::get('/metadata', 'metadata');
        Route::get('/stream', 'stream');
    });
});