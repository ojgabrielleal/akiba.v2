<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            session(['url.intended' => $request->url()]);

            return route('render.painel.auth')
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Você precisa estar logado para acessar esta página.',
                ]);
        }

        return null;
    }
}
