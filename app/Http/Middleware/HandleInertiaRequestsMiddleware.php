<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;

use App\Services\External\StreamingService;
use App\Services\Inertia\AuthContextService;

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
        return array_merge(parent::share($request), [
            'authenticated' => fn() => (new AuthContextService())->data(),
            'streaming' => fn() => (new StreamingService())->data(),
            'flash' => fn() => [
                'icon' => session('flash.icon'),
                'message' => session('flash.message'),
            ],
        ]);
    }

}
