<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\RadioController;

Route::group(['prefix' => 'radio'], function () {
    Route::controller(RadioController::class)->group(function () {
        Route::get('/stream', 'stream');
    });
});