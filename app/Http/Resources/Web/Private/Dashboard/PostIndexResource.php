<?php

namespace App\Http\Resources\Web\Private\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Traits\ResolvesUserLogged;

class PostIndexResource extends JsonResource
{
    use ResolvesUserLogged;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->getUserLogged();

        // Verify if user is author
        $userIsAuthor = $this->author->id === $user['id'];

        // Verify permissions 
        $canUpdate = $user['permissions']->contains('post.update');
        $canUpdateOwn = $user['permissions']->contains('post.update.own');

        return [
            'uuid' => $this->uuid,
            'status' => $this->status,
            'title' => $this->title,
            'author' => [
                'uuid' => $this->author->uuid,
                'nickname' => $this->author->nickname,
            ],
            'ui' => [
                'background' => 'bg-blue-skywave',
            ],
            'actions' => [
                'can_update' => $canUpdate || ($canUpdateOwn && $userIsAuthor),
            ],
        ];
    }
}
