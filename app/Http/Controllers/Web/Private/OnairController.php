<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Services\Domain\BroadcastService;
use App\Services\Domain\ShowService;
use App\Services\Domain\SongRequestService;

class OnairController extends Controller
{
    use FlashMessageTrait;

    public function startBroadcast(Request $request)
    {
        $request ->validate([
            'show' => 'required',
            'phrase' => 'required',
            'image' => 'required'
        ]);

        $logged = $request->user();

        $broadcastService = new BroadcastService();
        $broadcastService->start($logged, $request->all());

        return $this->flashMessage('save');
    }

    public function finishBroadcast()
    {
        $broadcastService = new BroadcastService();
        $broadcastService->finish();

        return $this->flashMessage('save');
    }

    public function setSongRequestIsPlayed($songRequestId)
    {
        $songRequest = new SongRequestService();
        $songRequest->setIsPlayed($songRequestId);
    
        return $this->flashMessage('save');
    }

    public function toggleSongRequestBoxStatus()
    {
        $songRequest = new SongRequestService();
        $songRequest->toggleStatus();
    
        return $this->flashMessage('save');
    }

    public function render()
    {
        $logged = request()->user();
        $songRequest = new SongRequestService();
        $show = new ShowService();

        return Inertia::render('admin/Onair', [
            "shows" => $show->list([
                'filters' => [
                    'is_active' => true, 
                    'or' => fn($q) => $q->where('user_id', $logged->id)->orWhere('is_all', true)
                ],
                'fields' => ['id', 'image'],
            ]),
            "songRequests" => $songRequest->list([
                'filters' => ['live' => true],
            ])
        ]);
    }
}
