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
            'slug' => $this->slug,
            'type' => $this->type,
            'title' => $this->title,
            'author' => [
                'uuid' => $this->author->uuid,
                'name' => $this->author->name,
                'nickname' => $this->author->nickname,
                'avatar' => $this->author->avatar,
            ],
        ];
    }
}
