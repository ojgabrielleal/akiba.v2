<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'cover' => $this->cover,
            'image' => $this->image,
            'title' => $this->title,
            'sinopse' => $this->sinopse,
            'reviews' => $this->reviews->map(fn($item) => [
                'uuid' => $item->uuid,
                'content' => $item->content,
                'author' => [
                    'uuid' => $item->author->uuid,
                    'name' => $item->author->name,
                    'nickname' => $item->author->nickname,
                    'avatar' => $item->author->avatar,
                    'gender' => $this->author->gender
                ],
            ]),
        ];
    }
}
