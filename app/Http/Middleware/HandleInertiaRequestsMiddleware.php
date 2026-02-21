<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

use App\Services\External\StreamingService;

use App\Traits\ResolvesUserLogged;

class HandleInertiaRequestsMiddleware extends Middleware
{
    use ResolvesUserLogged;

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
            'user' => fn() => $this->getUserLogged(),
            'streaming' => fn() => (new StreamingService())->data(),
            'flash' => fn() => [
                'icon' => session('flash.icon'),
                'message' => session('flash.message'),
            ],
        ]);
    }

}
