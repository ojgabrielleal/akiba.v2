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
        $radio = app(\App\Services\RadioAPIService::class);
        $metadata = $radio->getMetadata(); 
        $filteredMetadata = [
            'ouvintes_conectados' => $metadata['ouvintes_conectados'] ?? null,
            'plano_bitrate'       => $metadata['plano_bitrate'] ?? null,
            'status'              => $metadata['status'] ?? null,
        ];

        return array_merge(parent::share($request), [
            'authenticated' => function () {
                return Auth::check() ? Auth::user() : null;
            },

            'radio' => function() use ($filteredMetadata){
                return Auth::check() ? $filteredMetadata : null;
            },
    
            'flash' => [
                'type' => fn () => session('flash.type'),
                'message' => fn () => session('flash.message'),
            ],
        ]);
    }
}
