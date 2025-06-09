<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

          return redirect()->intended(route('dashboard.render.painel'));
        }

        return back()->withErrors([
            'username' => 'As credenciais informadas estão incorretas.',
        ])->onlyInput('username');
    }

    public function render()
    {
        return Inertia::render('Admin/Auth');
    }
}
