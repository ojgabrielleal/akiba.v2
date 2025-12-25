<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Services\Domain\MusicService;
use App\Services\Domain\ShowService;
use App\Services\Domain\ListenerMonthService;
use App\Services\Domain\ShowScheduleService;
use App\Services\Domain\UserService;

class RadioController extends Controller
{
    use FlashMessageTrait;

    public function getShow($showId)
    {
        $showService = new ShowService();
        return $showService->get($showId);
    }

    public function createShow(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
        ]);

        $authenticated = request()->user();
        
        $showService = new ShowService();
        $showCreate = $showService->create($authenticated, $request->all());

        if($showCreate) return $this->flashMessage('save');
    }

    public function updateShow(Request $request, $showId)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $showService = new ShowService();
        $showUpdate = $showService->update($showId, $request->all());

        if($showUpdate) return $this->flashMessage('update');
    }

    public function deactivateShow($showId)
    {
        $showService = new ShowService();
        $showDeactivate = $showService->deactivate($showId);

        if($showDeactivate) return $this->flashMessage('deactivate');
    }

    public function setRankingMusic()
    {
        $musicService = new MusicService();
        $musicUpdate = $musicService->setRanking();

        if($musicUpdate) return $this->flashMessage('save');
    }

    public function createListenerMonth(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);

        $listenerMonthService = new ListenerMonthService();
        $listenerMonthCreate = $listenerMonthService->create($request->all());

        if($listenerMonthCreate) return $this->flashMessage('save');
    }

    public function updateRankingMusicImage(Request $request, $musicId)
    {
        $musicService = new MusicService();
        $musicUpdate = $musicService->setRankingImage($musicId, $request->all());

        if($musicUpdate) return $this->flashMessage('update');
    }

    public function render()
    {
        $shows = new ShowService();
        $music = new MusicService();
        $listenerMonth = new ListenerMonthService();
        $showSchedule = new ShowScheduleService();
        $user = new UserService();

        return Inertia::render('admin/Radio', [
            "shows" => $shows->list(),
            "streamers" => $user->list(),
            "schedules" => $showSchedule->list(),
            "ranking" => $music->listRanking(),
            "listenerMonthRegistered" => $listenerMonth->get(),
            'listenerMonthFound' => $listenerMonth->found(),
        ]);
    }
}
