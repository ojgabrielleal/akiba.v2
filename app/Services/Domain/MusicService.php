<?php

namespace App\Services\Domain;
use App\Services\Process\ImageService;
use App\Models\Music;

class MusicService
{
    public function listRanking()
    {
        return Music::query()->where('is_ranking', true)->limit(3)->orderBy('song_request_total', 'desc')->get();
    }

    public function setRanking()
    {
        // Reset previous ranking
        Music::where('is_ranking', true)->update([
            'is_ranking' => false
        ]);

        // Set new ranking
        $musicQuery = Music::orderBy('song_request_total', 'desc')->limit(10)->get();
        $musicUpdate = $musicQuery->each(function ($music) {
            $music->update(['is_ranking' => true]);
        });

        return $musicUpdate;
    }

    public function setRankingImage($musicId, $data = [])
    {
        $image = new ImageService();

        $musicQuery = Music::findOrFail($musicId);
        $musicUpdate = $musicQuery->update([
            'image_ranking' => $image->upload('musics/ranking', $data['image_ranking'], 'public', $musicQuery->image_ranking ?? null),
        ]);

        return $musicUpdate;
    }
}
