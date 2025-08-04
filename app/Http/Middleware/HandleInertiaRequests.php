<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class HandleInertiaRequests extends Middleware
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
        return array_merge(parent::share($request), [
            'user' => function () {
                if (!Auth::check()) {
                    return null;
                }

                $user = User::with('permissions')->find(Auth::id());
                $user->setRelation('permissions', $user->permissions->pluck('permission'));

                return $user;
            },

            // Flash messages
            'flash' => [
                'type' => fn () => session('flash.type'),
                'message' => fn () => session('flash.message'),
            ],
        ]);
    }
}
