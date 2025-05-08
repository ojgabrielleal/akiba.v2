<?php

use Illuminate\Support\Facades\Route;

Route::prefix('painel')->group(function () {
    Route::get('/', function () {
        return view('livewire.auth');
    });

});