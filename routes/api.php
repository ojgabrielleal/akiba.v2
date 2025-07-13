<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CastController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Define the route for the cast audio API
Route::group(['prefix' => 'cast'], function () {
    Route::controller(CastController::class)->group(function () {
        Route::get('/data', 'data');
    });
});