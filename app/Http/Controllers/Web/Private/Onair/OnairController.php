<?php

namespace App\Http\Controllers\Web\Private\Onair;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

use App\Services\Controllers\ShowService;
use App\Services\Controllers\SongRequestService;

class OnairController extends Controller
{
    protected $showService;
    protected $songRequestService;

    public function __construct(ShowService $showService, SongRequestService $songRequestService)
    {
        $this->showService = $showService;
        $this->songRequestService = $songRequestService;
    }

    public function render()
    {
        $authenticated = request()->user();

        return Inertia::render('admin/Onair', [
            "shows" => $this->showService->list(
                ['is_active' => true],
                [
                    'fields' => ['id', 'image'],
                    'user_only' => $authenticated->id
                ],
            ),
            "songRequests" => $this->songRequestService->list(
                ['live' => true]
            )
        ]);
    }
}
