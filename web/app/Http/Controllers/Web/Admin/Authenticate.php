<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
            'error' => 'As credenciais informadas estão incorretas.',
        ], 422);
    }

    public function render()
    {
        return Inertia::render('Admin/Authenticate');
    }
}
