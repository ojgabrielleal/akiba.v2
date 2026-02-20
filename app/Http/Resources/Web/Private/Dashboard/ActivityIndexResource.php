<?php

namespace App\Http\Resources\Web\Private\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Base\ActivityBaseResource;
use App\Traits\ResolvesUserLogged;

class ActivityIndexResource extends ActivityBaseResource
{
    use ResolvesUserLogged;

    protected function user()
    {
        return $this->getUserLogged();
    }

    protected function actions(): array
    {
        if (!$this->allows_confirmations) {
            return ['participate' => null];
        }

        $user = $this->user();
        $canParticipate =  $user['permissions']->contains('activity.participate');
        $alreadyParticipates = $this->confirmations->contains(fn($item) => $item->confirmer?->id === $user['id']);

        return [
            'show_button_participate' => $canParticipate && ! $alreadyParticipates,
        ];
    }

    protected function ui(): array
    {
        return [
            'background' => $this->allows_confirmations ?
                'bg-neutral-honeycream' :
                'bg-blue-skywave',
            'texts' => $this->allows_confirmations ?
                'text-blue-midnight' :
                'text-neutral-aurora',
        ];
    }

    public function toArray(Request $request): array
    {
        return array_merge(
            $this->base(['uuid', 'content', 'allows_confirmations']),
            [
                'author' => $this->author(['uuid', 'nickname']),
                'confirmations' => $this->confirmations(['uuid', 'confirmer.uuid', 'confirmer.avatar']),
                'ui' => $this->ui(),
                'actions' => $this->actions(),
            ]
        );
    }
}
