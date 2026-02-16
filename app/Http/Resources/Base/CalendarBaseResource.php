<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Base\UserBaseResource;
use App\Http\Resources\Base\ActivityBaseResource;
use App\Traits\ResolvesResourcesFilters;

class CalendarBaseResource extends JsonResource
{
    use ResolvesResourcesFilters;

    public function base(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $data = [
            'uuid' => $this->uuid,
            'has_activity' => $this->has_activity,
            'time' => $this->time->format('H:m'),
            'date' => $this->date->format('Y-m-d'),
            'content' => $this->content,
        ];

        return $this->filterFields($data, $fields);
    }

    public function responsible(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $user = new UserBaseResource($this->responsible);

        $responsibleData = $user->base();
        
        if (!empty($fields)) {
            $responsibleData = $this->filterFields($responsibleData, $fields);
        }

        return [
            'responsible' => $responsibleData,
        ];
    }

    public function activity(array $fields = []): array
    {
        if (!$this->resource || !$this->has_activity) {
            return [];
        }

        $activity = new ActivityBaseResource($this->activity);

        $activityData = $activity->base();
        if (!empty($fields)) {
            $activityData = $this->filterFields($activityData, $fields);
        }

        return [
            'activity' => $activityData,
        ];
    }
}
