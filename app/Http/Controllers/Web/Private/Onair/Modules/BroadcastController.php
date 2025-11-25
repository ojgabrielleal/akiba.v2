<?php

namespace App\Http\Controllers\Web\Private\Onair\Modules;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\External\DiscordWebhookService;
use App\Traits\Response\FlashMessageTrait;

use App\Models\Show;
use App\Models\Onair;
use App\Models\SongRequest;
use App\Models\AutoDJ;

class BroadcastController extends Controller
{
    use FlashMessageTrait;

    protected $discordWebhook;

    public function __construct(DiscordWebhookService $discordWebhookService)
    {
        $this->discordWebhook = $discordWebhookService;
    }

    public function startBroadcast(Request $request)
    {
        $request->validate([
            'show' => 'required',
            'phrase' => 'required',
            'image' => 'required',
        ]);
        
        Onair::where('is_live', true)->update([
            'is_live' => false,
            'listener_request_status' => false,
        ]);

        $authenticated = request()->user();
        $show = Show::findOrFail($request->input('show'));

        if ($show->is_all) {
            if ($show->user_id !== $authenticated->id) {
                $show->update([
                    'user_id' => $authenticated->id
                ]);
            }
        }

        $show->onair()->create([
            'phrase' => $request->input('phrase'),
            'image' => $request->input('image'),
            'listener_request_status' => true,
            'category' => 'live'
        ]);

        $this->discordWebhook->sendBroadcastNotification($authenticated, $show);
        return $this->flashMessage('startBroadcast');
    }

    public function finishBroadcast()
    {
        $onair = Onair::where('is_live', true)->firstOrFail();
        $autoDJ = AutoDJ::with('phrases')->firstOrFail();

        SongRequest::where('is_played', false)->where('onair_id', $onair->id)->update([
            'is_canceled' => true,
        ]);
        
        $onair->update([
            'is_live' => false,
            'listener_request_status' => false
        ]);

        $phrase = $autoDJ->phrases->random();
        $autoDJ->onair()->create([
            'type' => 'auto',
            'phrase' => $phrase->phrase,
            'image' => $phrase->image,
        ]);

        return $this->flashMessage('finishBroadcast');
    }
}
