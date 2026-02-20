<?php

namespace App\Http\Resources\Web\Private\Posts;

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
        $backgroundColors = [
            'published' => 'bg-blue-skywave',
            'revision' => 'bg-orange-amber',
            'sketch' => 'bg-green-forest',
        ];

        return [
            'background' => $backgroundColors[$this->status],
        ];
    }

    protected function actions(): array
    {
        $user = $this->user();

        $userCanUpdate = $user['permissions']->contains('post.update');
        $userCanUpdateOwn = $user['permissions']->contains('post.update.own');;

        return [
            'show_button_update' => $userCanUpdate || $userCanUpdateOwn,
        ];
    }


    public function toArray(Request $request): array
    {
        return array_merge(
            $this->base(['uuid', 'title']),
            [
                'author' => $this->author(['uuid', 'nickname']),
                'ui' => $this->ui(),
                'actions' => $this->actions()
            ]
        );
    }
}
