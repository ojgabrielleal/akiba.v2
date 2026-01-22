<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Models\Onair;
use App\Models\Program;
use App\Models\AutoDJ;
use App\Models\SongRequest;

use App\Services\External\DiscordWebhookService;

class OnairController extends Controller
{
    use FlashMessageTrait;

    private DiscordWebhookService $discord;
    private $render = 'private/Medias';

    public function __construct(DiscordWebhookService $discord)
    {
        $this->discord = $discord;
    }

    public function indexPrograms()
    {
        return Program::active()
            ->where('user_id', request()->user()->id)
            ->orWhere('allow_all', true)
            ->get();
    }

    public function indexSongRequests()
    {
        $onair = Onair::live()->firstOrFail();
        return SongRequest::queued()
            ->where('onair_id', $onair->id)
            ->get();
    }

    public function startBroadcast(Request $request)
    {
        $request ->validate([
            'program' => 'required',
            'phrase' => 'required',
            'image' => 'required'
        ]);

        $onair = Onair::live()->firstOrFail();
        $program = Program::findOrFail($request->input('program'));

        $onair->update([
            'is_live' => false,
            'allows_songs_requests' => false,
        ]);

        $program->onair()->create([
            'phrase' => $request->input('phrase'),
            'image' => $request->input('image'),
            'allows_songs_requests' => true,
            'type' => 'live',
        ]);

        $this->discord->sendHookMessage(request()->user(), $program);
        return $this->flashMessage('startBroadcast');
    }

    public function finishBroadcast()
    {
        $onair = Onair::live()->firstOrFail();
        $songRequests = SongRequest::queued()->where('onair_id', $onair->id)->get();
        $autoDJ = AutoDJ::with('phrases')->firstOrFail();
        $autoDJPhrase = $autoDJ->phrases->random();

        $songRequests->update([
            'is_canceled' => true,
        ]);

        $onair->update([
            'is_live' => false,
            'allows_songs_requests' => false,
        ]);

        $autoDJ->onair()->create([
            'type' => 'auto_dj',
            'phrase' => $autoDJPhrase->phrase,
            'image' => $autoDJPhrase->image,
        ]);

        return $this->flashMessage('finishBroadcast');
    }

    public function markSongRequestAsPlayed(SongRequest $songRequest)
    {
        $songRequest->update([
            'is_played' => true,
        ]);

        return $this->flashMessage('songRequestPlayed');
    }

    public function toggleSongRequestBoxEnabled()
    {
        $onair = Onair::live()->firstOrFail();
        $onair->update([
            'allows_songs_requests' => !$onair->allows_songs_requests,
        ]);

        return $this->flashMessage('save');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            "programs" => $this->indexPrograms(),
            "songRequests" => $this->indexSongRequests(),
        ]);
    }
}
