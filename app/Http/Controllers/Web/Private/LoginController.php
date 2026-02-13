<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

class LoginController extends Controller
{
    private $render = 'private/Login';

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials['is_active'] = true;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return to_route('painel.dashboard');
        }

        return Inertia::render($this->render)->with('flash', [
            'icon' => "😠",
            'message' => "Usuário ou senha incorretos",
        ]);
    }

    public function render()
    {
        return Inertia::render($this->render);
    }
}
