<?php

namespace App\Http\Resources\Web\Private\Posts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Base\PostBaseResource;
use App\Traits\ResolvesUserLogged;

class PostGetResource extends PostBaseResource
{
    use ResolvesUserLogged;

    protected function user()
    {
        return $this->getUserLogged();
    }

    protected function actions(): array
    {
        $user = $this->user();

        $isAuthor = $this->author->id === $user['id'];
        
        $canCreate = $user['permissions']->contains('post.create');
        $canUpdate = $user['permissions']->contains('post.update');
        $canUpdateOwn = $user['permissions']->contains('post.update.own');

        return [
            'can_create' => $canCreate,
            'can_update' => $canUpdate || ($canUpdateOwn && $isAuthor),
        ];
    }

    public function toArray(Request $request): array
    {
        return array_merge(
            $this->base(),
            [
                'references' => $this->references(),
                'categories' => $this->categories(),
                'actions' => $this->actions(),
            ]
        );
    }
}
