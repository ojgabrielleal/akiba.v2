<?php

namespace App\Services\Domain;

use App\Services\External\DiscordWebhookService;
use App\Models\Onair;
use App\Models\Show;
use App\Models\SongRequest;
use App\Models\AutoDJ;

class BroadcastService
{
    public function start($authenticated = [], $data = [])
    {
        $onairQuery = Onair::where('is_live', true)->firstOrFail();
        $showQuery = Show::findOrFail($data['show']);

        if ($showQuery->is_all) {
            if ($showQuery->user_id !== $authenticated['id']) {
                $showQuery->update([
                    'user_id' => $authenticated['id']
                ]);
            }
        }

        $onairQuery->update([
            'is_live' => false,
            'listener_request_status' => false,
        ]);

        $onairCreate = $showQuery->onair()->create([
            'phrase' => $data['phrase'],
            'image' => $data['image'],
            'listener_request_status' => true,
            'category' => 'live'
        ]);

        $discordWebhook = new DiscordWebhookService();
        $discordWebhook->sendBroadcastNotification($authenticated, $showQuery);

        return $onairCreate;
    }

    public function finish()
    {
        $onairQuery = Onair::where('is_live', true)->firstOrFail();
        $autoDJQuery = AutoDJ::with('phrases')->firstOrFail();
        $songRequestQuery = SongRequest::where('is_played', false)->where('onair_id', $onairQuery->id)->get();

        $songRequestQuery->update([
            'is_canceled' => true,
        ]);

        $onairQuery->update([
            'is_live' => false,
            'listener_request_status' => false
        ]);

        $phrase = $autoDJQuery->phrases->random();
        $onairCreate = $autoDJQuery->onair()->create([
            'type' => 'auto',
            'phrase' => $phrase->phrase,
            'image' => $phrase->image,
        ]);

        return $onairCreate;
    }
}
