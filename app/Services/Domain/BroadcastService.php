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
        Onair::where('is_live', true)->update([
            'is_live' => false,
            'listener_request_status' => false,
        ]);

        $show = Show::findOrFail($data['show']);
        if ($show->is_all) {
            if ($show->user_id !== $authenticated['id']) {
                $show->update([
                    'user_id' => $authenticated['id']
                ]);
            }
        }

        $onairCreate = $show->onair()->create([
            'phrase' => $data['phrase'],
            'image' => $data['image'],
            'listener_request_status' => true,
            'category' => 'live'
        ]);

        $discordWebhook = new DiscordWebhookService();
        $discordWebhook->sendBroadcastNotification($authenticated, $show);

        return $onairCreate;
    }

    public function finish()
    {
        $onairQuery = Onair::where('is_live', true)->firstOrFail();
        $autoDJQuery = AutoDJ::with('phrases')->firstOrFail();

        SongRequest::where('is_played', false)->where('onair_id', $onairQuery->id)->update([
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