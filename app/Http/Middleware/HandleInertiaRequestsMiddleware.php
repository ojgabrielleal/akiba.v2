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
        function loadPermissions()
        {
            if (!Auth::check()) {
                return null;
            }

            /** @var User $user */
            $user = Auth::user();

            return $user
                ->load('roles.permissions')
                ->roles
                ->flatMap->permissions
                ->pluck('name')
                ->unique()
                ->values();
        }

        return array_merge(parent::share($request), [
            'permissions' => fn() => loadPermissions(),
            'flash' => fn() => [
                'type' => session('flash.type'),
                'message' => session('flash.message'),
            ],
        ]);
    }
}
