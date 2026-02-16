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

    protected function ui(): array
    {
        return [
            'ui' => [
                'background' => $this->allows_confirmations ? 
                    'bg-neutral-honeycream' : 
                    'bg-blue-skywave',
                'texts' => $this->allows_confirmations ? 
                    'text-blue-midnight' : 
                    'text-neutral-aurora',
            ]
        ];
    }

    protected function actions(): array
    {
        if (!$this->allows_confirmations) {
            return ['participate' => null];
        }

        $user = $this->user();
        $userCanParticipate =  $user['permissions']->contains('activity.participate');
        $userAlreadyParticipates = $this->confirmations->contains(
            fn($confirmation) => $confirmation->confirmer?->id === $user['id']
        );

        return [
            'actions' => [
                'participate' => $userCanParticipate && ! $userAlreadyParticipates,
            ]
        ];
    }

    public function toArray(Request $request): array
    {
        return array_merge(
            $this->base(['uuid', 'content', 'allows_confirmations']),
            $this->author(['uuid','nickname']),
            $this->confirmations(['uuid', 'confirmer.avatar']),
            $this->ui(),
            $this->actions(),
        );
    }
}
