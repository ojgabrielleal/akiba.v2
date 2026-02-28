<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Onair;
use App\Models\Program;
use App\Models\AutoDJ;
use App\Models\SongRequest;

use App\Http\Resources\ProgramIndexResource;
use App\Http\Resources\OnairShowResource;

use App\Services\External\DiscordWebhookService;
use App\Traits\HasFlashMessages;

class BroadcastController extends Controller
{
    use HasFlashMessages;

    private DiscordWebhookService $discord;
    private $render = 'private/Broadcast';

    public function __construct(DiscordWebhookService $discord)
    {
        $this->discord = $discord;
    }

    public function indexPrograms()
    {
        return ProgramIndexResource::collection(
            Program::active()
                ->where(function($q) {
                    $q->where('user_id', request()->user()->id)
                        ->orWhere('allows_all', true);
                })
                ->get()
        );
    }

    public function indexSongRequests()
    {
        $onair = Onair::live()->get();
        return SongRequest::queued()
            ->where('onair_id', $onair->id)
            ->get();
    }

    public function showOnair()
    {
        return new OnairShowResource(Onair::live()->first());
    }

    public function startBroadcast(Request $request, Program $program)
    {
        $request ->validate([
            'phrase' => 'required', 
            'image' => 'required'
        ]);

        Onair::live()->first()->update([
            'is_live' => false,
            'song_requests_total' => false,
        ]);

        $program->onair()->create([
            'phrase' => $request->input('phrase'),
            'image' => $request->input('image'),
            'song_requests_total' => true,
            'type' => 'live',
        ]);

        $this->discord->sendHookMessage(request()->user(), $program);
        return $this->flashMessage('start');
    }

    public function finishBroadcast()
    {
        $onair = Onair::live()->get();
        $songRequests = SongRequest::queued()->where('onair_id', $onair->id)->get();
        $autoDJ = AutoDJ::with('phrases')->get();
        $autoDJPhrase = $autoDJ->phrases->random();

        $songRequests->update([
            'is_canceled' => true,
        ]);

        $onair->update([
            'is_live' => false,
            'song_requests_total' => false,
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
        $onair = Onair::live()->get();
        $onair->update([
            'song_requests_total' => !$onair->song_requests_total,
        ]);

        return $this->flashMessage('save');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            "programs" => $this->indexPrograms(),
            "onair" => $this->showOnair(),
            //"songRequests" => $this->indexSongRequests(),
        ]);
    }
}
