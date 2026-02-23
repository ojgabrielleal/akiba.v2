<?php

namespace App\Http\Resources;

use App\Traits\ResolvesUserLogged;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ReviewShowResource extends JsonResource
{
    use ResolvesUserLogged;

    protected function user(): array
    {
        return $this->getUserLogged();
    }

    protected function userHasReview(): bool
    {
        $user = $this->user();

        return $this->reviews->contains(
            fn ($item) => $item->author->uuid === $user['uuid']
        );
    }

    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'cover' => $this->cover,
            'image' => $this->image,
            'title' => $this->title,
            'sinopse' => $this->sinopse,
            'has_user_review' => $this->userHasReview(),
            'reviews' => $this->reviews->map(fn ($item) => [
                'uuid' => $item->uuid,
                'content' => Str::limit($item->content, 50, '...'),
                'author' => [
                    'uuid' => $item->author->uuid,
                    'name' => $item->author->name,
                    'nickname' => $item->author->nickname,
                    'avatar' => $item->author->avatar,
                ],
            ]),
        ];
    }
}
