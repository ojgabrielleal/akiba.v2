<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated if not redirect to the login page
        if (!Auth::check()) {
            return redirect()->route('render.painel.auth')->with('flash', [
                'type' => 'error',
                'message' => 'Você precisa estar logado para acessar esta página.',
            ]);
        }

        // Share the authenticated user with Inertia
        Inertia::share('user', fn() => Auth::check() ? Auth::user() : null);

        return $next($request);
    }
}
