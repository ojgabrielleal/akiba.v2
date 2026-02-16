<?php

namespace App\Http\Resources\Web\Private\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Base\PostBaseResource;
use App\Traits\ResolvesUserLogged;

class PostIndexResource extends PostBaseResource
{
    use ResolvesUserLogged;

    protected function user()
    {
        return $this->getUserLogged();
    }

    protected function ui(): array
    {
        return [
            'ui' => [
                'background' => 'bg-blue-skywave',
            ]
        ];
    }

    protected function actions(): array
    {
        $user = $this->user();
        $userIsAuthor = $this->author->id === $user['id'];
        $userCanUpdate = $user['permissions']->contains('post.update');
        $userCanUpdateOwn = $user['permissions']->contains('post.update.own');;

        return [
            'actions' => [
                'can_update' => $userCanUpdate || ($userCanUpdateOwn && $userIsAuthor),
            ]
        ];
    }

    public function toArray(Request $request): array
    {
        return array_merge(
            $this->base(['uuid', 'title']),
            $this->author(['uuid', 'nickname']),
            $this->ui(),
            $this->actions()
        );
    }
}
