<?php

namespace App\Http\Resources\Web\Private\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Traits\ResolvesUserLogged;

class ActivityIndexResource extends JsonResource
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

        // Verify if user has participate
        $userIsParticipating = $this->confirmations->contains(function ($confirmation) use ($user) {
            return $confirmation->confirmer?->id === $user['id'];
        });
        
        //Verify permissions 
        $canParticipate = $user['permissions']->contains('activity.participate');

        return [
            'uuid' => $this->uuid,
            'allows_confirmations' => $this->allows_confirmations,
            'author' => [
                'uuid' => $this->author->uuid,
                'nickname' => $this->author->nickname,
            ],
            'content' => $this->content,
            'confirmations' => $this->confirmations->map(fn($item) => [
                'uuid' => $item->uuid,
                'confirmer' => [
                    'avatar' => $item->confirmer->avatar
                ]
            ]),
            'ui' => [
                'background' => $this->allows_confirmations ? 'bg-neutral-honeycream' : 'bg-blue-skywave',
                'texts' => $this->allows_confirmations ? 'text-blue-midnight' : 'text-neutral-aurora',
            ],
            'actions' => [
                'participate' =>  $this->allows_confirmations ? ($canParticipate && !$userIsParticipating) : null
            ]

        ];
    }
}
