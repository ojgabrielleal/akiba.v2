<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OnairShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'program' => [
                'uuid' => $this->program->uuid,
                'name' => $this->program->name,
                'image' => $this->program->image,
                'host' => [
                    'uuid' => $this->program->host->uuid,
                    'name' => $this->program->host->name,
                    'nickname' => $this->program->host->nickname,
                    'avatar' => $this->program->host->avatar,
                    'gender' => $this->program->host->gender
                ]
            ],
            'phrase' => $this->phrase,
            'type' => $this->type,
            'image' => $this->image,
            'allows_song_requests' => $this->allows_song_requests,
            'song_requests_total' => $this->song_requests_total
        ];
    }
}
