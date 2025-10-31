<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;

class ProfileController extends Controller
{
    public function render()
    {
        return Inertia::render('admin/Profile');
    }
}
