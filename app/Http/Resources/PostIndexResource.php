<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'status' => $this->status,
            'title' => $this->title,
            'author' => [
                'uuid' => $this->author->uuid,
                'nickname' => $this->author->nickname,
                'avatar' => $this->author->avatar,
            ],
        ];
    }
}
