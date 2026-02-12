<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\HasFlashMessages;
use App\Services\Process\ImageService;

use App\Models\Podcast;

class PodcastsController extends Controller
{
    use HasFlashMessages;

    private ImageService $image;
    private $render = 'private/Podcasts';

    public function __construct(ImageService $image)
    {
        $this->image = $image;
    }

    public function indexPodcasts()
    {
        return Podcast::active()
                ->with('author')
                ->paginate(10);
    }

    public function showPodcast(Podcast $podcast)
    {
        return Inertia::render($this->render, [
            'podcast' => $podcast->load('author'),
        ]);
    }

    public function createPodcast(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'season' => 'required|unique:podcasts,season',
            'episode' => 'required|unique:podcasts,episode',
            'title' => 'required',
            'summary' => 'required',
            'description' => 'required',
            'audio' => 'required'
        ]);

        Podcast::create([
            'user_id' => request()->user()->id,
            'image' => $this->image->store('podcasts', $request->file('image')),
            'season' => $request->input('season'),
            'episode' => $request->input('episode'),
            'title' => $request->input('title'),
            'summary' => $request->input('summary'),
            'description' => $request->input('description'),
            'audio' => $request->input('audio'),
        ]);

        return $this->flashMessage('save');
    }

    public function updatePodcast(Request $request, Podcast $podcast)
    {
        $podcast->fill([
            'image' => $this->image->store('podcasts', $request->file('image'), 'public', $podcast->image),
            'season' => $request->input('season', $podcast->season),
            'episode' => $request->input('episode', $podcast->episode),
            'title' => $request->input('title', $podcast->title),
            'summary' => $request->input('summary', $podcast->summary),
            'description' => $request->input('description', $podcast->description),
            'audio' => $request->input('audio', $podcast->audio),
        ]);

        if($podcast->isDirty()) {
            $podcast->save();
        }

        return $this->flashMessage('update');
    }

    public function deactivatePodcast(Podcast $podcast)
    {
        $podcast->update([
            'is_active' => false,
        ]);

        return $this->flashMessage('deactivate');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'podcasts' => $this->indexPodcasts(),
        ]);
    }
}
