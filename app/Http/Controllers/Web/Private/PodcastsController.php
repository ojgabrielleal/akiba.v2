<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Services\Domain\PodcastService;

class PodcastsController extends Controller
{
    use FlashMessageTrait;

    public function createPodcast(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'season' => 'required',
            'episode' => 'required',
            'title' => 'required',
            'summary' => 'required',
            'description' => 'required',
            'audio' => 'required'
        ]);

        $logged = request()->user();

        $podcastService = new PodcastService();
        $podcastCreate = $podcastService->create($logged, $request->all());

        if($podcastCreate) return $this->flashMessage('save');
    }

    public function updatePodcast(Request $request, $podcastId)
    {
        $request->validate([
            'season' => 'required',
            'episode' => 'required',
            'title' => 'required',
            'summary' => 'required',
            'description' => 'required',
            'audio' => 'required'
        ]);
       
        $podcastService = new PodcastService();
        $podcastUpdate = $podcastService->update($podcastId, $request->all());
        
        if($podcastUpdate) return $this->flashMessage('update');
    }

    public function deactivatePodcast($podcastId)
    {
        $podcastService = new PodcastService();
        $podcastDeactivate = $podcastService->deactivate($podcastId);
       
        if($podcastDeactivate) return $this->flashMessage('deactivate');
    }

    public function render($podcastSlug = null)
    {
        $podcastService = new PodcastService();

        return Inertia::render('admin/Podcasts', [
            'podcasts' => $podcastService->list(),
            'podcast' => $podcastService->get($podcastSlug)
        ]);
    }
}
