<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Onair;
use App\Models\Program;
use App\Models\AutoDJ;
use App\Models\SongRequest;

use App\Http\Resources\OnairShowResource;
use App\Http\Resources\ProgramIndexResource;
use App\Http\Resources\SongRequestIndexResource;

use App\Services\External\DiscordWebhookService;
use App\Traits\HasFlashMessages;
use Illuminate\Support\Facades\Log;

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
                ->where(function ($q) {
                    $q->where('user_id', request()->user()->id)
                        ->orWhere('allows_all', true);
                })
                ->get()
        );
    }

    public function indexSongRequests()
    {
        $onair = Onair::live()->first();

        return SongRequestIndexResource::collection(
            SongRequest::where('onair_id', $onair->id)->get()
        );
    }

    public function showOnair()
    {
        return new OnairShowResource(Onair::live()->with('program.host')->first());
    }

    public function startBroadcast(Request $request, Program $program)
    {
        $request->validate([
            'phrase' => 'required',
            'image' => 'required'
        ]);

        Onair::live()->first()->update([
            'is_live' => false,
            'song_requests_total' => false,
        ]);

        if($program->allows_all){
            $program->update([
                'user_id' => request()->user()->id
            ]);
        }

        $program->onair()->create([
            'type' => 'live',
            'phrase' => $request->input('phrase'),
            'image' => $request->input('image'),
            'allows_song_requests' => true,
        ]);

        $this->discord->sendHookMessage(request()->user(), $program);
        return $this->flashMessage('start');
    }

    public function finishBroadcast()
    {
        $onair = Onair::live()->first();
        $onair->update([
            'is_live' => false,
            'allows_song_requests' => false,
        ]);

        $autodj = AutoDJ::with('phrases')->first();
        $phrase = $autodj->phrases->random();
        $autodj->onair()->create([
            'type' => 'auto',
            'phrase' => $phrase->phrase,
            'image' => $phrase->image,
        ]);

        SongRequest::where('onair_id', $onair->id)
            ->where('was_reproduced', false)
            ->where('was_canceled', false)
            ->update([
                'was_canceled' => true,
            ]);

        return $this->flashMessage('finish');
    }

    public function markSongRequestAsPlayed(SongRequest $songRequest)
    {
        $songRequest->update([
            'was_reproduced' => true,
        ]);

        $songRequest->onair()->increment('song_requests_total');
        return $this->flashMessage('save');
    }

    public function markSongRequestAsCanceled(SongRequest $songRequest)
    {
        $songRequest->update([
            'was_canceled' => true,
        ]);

        $songRequest->onair()->decrement('song_requests_total');
        return $this->flashMessage('save');
    }


    public function toggleSongRequestBoxStatus()
    {
        $onair = Onair::live()->first();
        $onair->update([
            'allows_song_requests' => !$onair->allows_song_requests,
        ]);

        return $this->flashMessage('save');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            "programs" => $this->indexPrograms(),
            "onair" => $this->showOnair(),
            "songrequests" => $this->indexSongRequests(),
        ]);
    }
}
