<?php

namespace App\Http\Controllers\Web\Private\Onair\Modules;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\Response\FlashMessageTrait;

use App\Models\Onair;
use App\Models\SongRequest;

class SongRequestController extends Controller
{
    use FlashMessageTrait;

    public function setIsPlayed($songRequestId)
    {
        $request = SongRequest::findOrFail($songRequestId);
        $request->update([
            'is_played' => !$request->is_played
        ]);

        return $this->flashMessage('songRequestPlayed');
    }

    public function toggleStatus()
    {
        $onair = Onair::where('is_live', true)->firstOrFail();
        $onair->update([
            'song_request_status' => !$onair->song_request_status
        ]);

        if ($onair->song_request_status) {
            return $this->flashMessage('songRequestOpen');
        } else {
            return $this->flashMessage('songRequestClose');
        }
    }
}
