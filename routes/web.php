<?php

use Illuminate\Support\Facades\Route;


// WEB ROUTES
Route::name('render.')->group(base_path('routes/web/render.php'));
Route::prefix('action')->name('actions.')->group(base_path('routes/web/actions.php'));
