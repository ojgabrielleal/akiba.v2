<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequestsMiddleware extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     */

    public function share(Request $request): array
    {
        function loadUser()
        {
            if (!Auth::check()) {
                return null;
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();

            $user->load('roles.permissions');

            return [
                'slug' => $user->slug,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'avatar' => $user->avatar,
                'permissions' => $user->roles
                    ->flatMap(fn($role) => $role->permissions)
                    ->unique('id')
                    ->values(),
            ];
        }

        return array_merge(parent::share($request), [
            'logged' => fn() => loadUser(),
            'flash' => fn() => [
                'type' => session('flash.type'),
                'message' => session('flash.message'),
            ],
        ]);
    }
}
