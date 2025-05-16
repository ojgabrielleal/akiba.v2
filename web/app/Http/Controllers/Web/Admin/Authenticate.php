<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class Authenticate extends Controller
{

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'redirect' => "painel/dashboard",
            ]);
        }

        return response()->json([
            'message' => 'As credenciais informadas não são válidas.',
        ], 401);
    }

    public function render()
    {
        return Inertia::render('Admin/Authenticate');
    }
}
