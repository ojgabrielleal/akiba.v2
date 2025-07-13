<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use App\Models\User;

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
        Inertia::share('user', function () {
            if (!Auth::check()) {
                return null;
            }

            $user = User::with('permissions')->find(Auth::id());

            // Sobrescreve a collection para apenas os nomes das permissões
            $user->setRelation('permissions', $user->permissions->pluck('permission'));

            return $user;
        });
        return $next($request);
    }
}
