<?php

namespace App\Http\Controllers\Web\Private\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials['is_active'] = true;

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
