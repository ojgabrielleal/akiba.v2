<?php

namespace App\Http\Resources\Web\Private\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Verify if user is author
        $user = request()->user();
        $verifyIfisAuthor = $this->author->id === $user->id;

        return [
            'uuid' => $this->uuid,
            'is_author' => $verifyIfisAuthor,
            'status' => $this->status, 
            'title' => $this->title, 
            'author' => [
                'uuid' => $this->author->uuid,
                'nickname' => $this->author->nickname,
            ],
        ];
    }
}
