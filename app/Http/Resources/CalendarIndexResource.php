<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'has_activity' => $this->has_activity,
            'title' => $this->title,
            'time' => $this->time->format('H:m'),
            'date' => $this->date->format('Y-m-d'),
            'content' => $this->content,
            'category' => $this->category,
            'responsible' => [
                'uuid' => $this->responsible->uuid,
                'name' => $this->responsible->name,
                'nickname' => $this->responsible->nickname,
                'avatar' => $this->responsible->avatar,
            ],
            'activity' => $this->has_activity ? [
                'uuid' => $this->activity->uuid,
                'title' => $this->activity->title,
            ] : null,
        ];
    }
}
