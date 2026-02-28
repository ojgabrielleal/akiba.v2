<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SongRequestIndexResource extends JsonResource
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
            'was_reproduced' => $this->was_reproduced,
            'was_canceled' => $this->was_canceled,
            'ip' => $this->ip,
            'name' => $this->name,
            'address' => $this->address,
            'message' => $this->message,
            'music' => [
                'uuid' => $this->music->uuid,
                'type' => $this->music->type,
                'image' => $this->music->image,
                'name' => $this->music->name,
                'artist' => $this->music->artist,
                'production' => $this->music->production,
            ],
            'created_at' => $this->created_at->setTimezone('UTC')->format('H:i'),
        ];
    }
}
