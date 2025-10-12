<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CastController;

// Define the route for the cast audio API
Route::group(['prefix' => 'cast'], function () {
    Route::controller(CastController::class)->group(function () {
        Route::get('/metadata', 'metadata');
        Route::get('/stream', 'stream');
    });
});