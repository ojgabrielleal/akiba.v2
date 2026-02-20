<?php

namespace App\Http\Resources\Web\Private\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Base\CalendarBaseResource;
use App\Traits\ResolvesUserLogged;

class CalendarIndexResource extends CalendarBaseResource
{
    use ResolvesUserLogged;

    protected function user()
    {
        return $this->getUserLogged();
    }

    protected function ui()
    {
        $colorCategories = [
            'show' => 'bg-blue-skywave',
            'live' => 'bg-purple-mystic',
            'youtube' => 'bg-red-crimson',
            'podcast' => 'bg-green-forest',
            'activity' => 'bg-neutral-honeycream',
        ];

        return [
            'background' => $colorCategories[$this->category],
            'texts' => $this->has_activity ?
                'text-blue-midnight' :
                'text-neutral-aurora',
            'filters' => $this->has_activity ?
                'filter-blue-midnight' :
                'filter-neutral-aurora',
        ];
    }

    protected function actions()
    {
        $user = $this->user();
        $canUpdate = $user['permissions']->contains('calendar.update');

        return  [
            'show_button_update' => $canUpdate
        ];
    }

    public function toArray(Request $request): array
    {
        return array_merge(
            $this->base(['uuid', 'has_activity', 'time', 'date', 'content']),
            [
                'responsible' => $this->responsible(['uuid','uuid','nickname']),
                'activity' => $this->activity(['uuid', 'title']),
                'ui' => $this->ui(),
                'actions' => $this->actions(),
            ],
        );
    }
}
