<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

class MediasController extends Controller
{
    public function render()
    {
        return Inertia::render('admin/Medias');
    }
}
