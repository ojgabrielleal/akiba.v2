<?php

namespace App\Http\Resources\Web\Private\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityIndexResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Verify if user has participate
        $user = request()->user();
        $userIsParticipating = $this->confirmations->contains(function($confirmation) use ($user) {
            return $confirmation->confirmer->id === $user->id;
        });

        return [
            'uuid' => $this->uuid,
            'allows_confirmations' => $this->allows_confirmations,
            'is_participating' => $userIsParticipating,
            'author' => [ 
                'uuid' => $this->author->uuid,
                'nickname' => $this->author->nickname,
            ],
            'content' => $this->content,
            'confirmations' => $this->confirmations->map(fn($item)=>[
                'uuid' => $item->uuid,
                'confirmer' => [
                    'avatar' => $item->confirmer->avatar
                ]
            ])
        ];
    }
}
