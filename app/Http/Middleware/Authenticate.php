<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            session(['url.intended' => $request->url()]);
            session()->flash('flash', [
                'type' => 'error',
                'message' => 'Você precisa estar logado para acessar.',
            ]);
            return route('render.painel.auth');
        }

        return null;
    }
}
