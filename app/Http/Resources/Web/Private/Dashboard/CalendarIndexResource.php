<?php

namespace App\Http\Resources\Web\Private\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Traits\ResolvesUserLogged;

class CalendarIndexResource extends JsonResource
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

        //Verify permissions 
        $canUpdate = $user['permissions']->contains('calendar.update');

        //Object to color categories on calendar 
        $colorCategories = [
            'live' => 'bg-purple-mystic',
            'youtube' => 'bg-red-crimson',
            'podcast' => 'bg-green-forest',
            'activity' => 'bg-neutral-honeycream',
        ];

        return [
            'uuid' => $this->uuid,
            'has_activity' => $this->has_activity,
            'time' => $this->time->format('H:m'),
            'date' => $this->date->format('Y-m-d'),
            'content' => $this->content,
            'responsible' => [
                'uuid' => $this->responsible->uuid,
                'nickname' => $this->responsible->nickname,
            ],
            'activity' => $this->activity ? [
                'title' => $this->activity->title
            ] : null,
            'ui' => [
                'background' => $colorCategories[$this->category],
                'texts' => $this->has_activity ? 'text-blue-midnight' : 'text-neutral-aurora',
                'filters' => $this->has_activity ? 'filter-blue-midnight' : 'filter-neutral-aurora',
            ],
            'actions' => [
                'can_update' => $canUpdate
            ]
        ];
    }
}
