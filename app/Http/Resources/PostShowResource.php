<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class PostShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'type' => $this->type,
            'title' => $this->title,
            'image' => $this->image,
            'cover' => $this->cover,
            'content' => $this->content,
            'author' => [
                'uuid' => $this->author->uuid,
                'name' => $this->author->name,
                'nickname' => $this->author->nickname,
                'avatar' => $this->author->avatar,
            ],
            'references' => $this->references->map(fn($item) => [
                'uuid' => $item->uuid,
                'name' => $item->name,
                'url' => $item->url
            ]),
            'reactions' => $this->reactions->map(fn($item) => [
                'uuid' => $item->uuid,
                'name' => $item->name
            ]),
            'categories' => $this->categories->map(fn($item) => [
                'uuid' => $item->uuid,
                'name' => $item->name,
            ])
        ];        
    }
}
