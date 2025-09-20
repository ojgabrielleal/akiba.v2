<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('render.painel.dashboard');
        }

        return back(303)->with('flash', [
            'type' => 'error',
            'message' => "Login ou senha incorretos",
        ]);
    }

    public function render()
    {
        return Inertia::render('admin/Auth');
    }
}
