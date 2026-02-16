<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

use App\Http\Resources\Base\UserBaseResource;

class TaskBaseResource extends JsonResource
{
    protected function filterFields(array $data, array $fields = []): array
    {
        if (empty($fields)) {
            return $data;
        }

        return Arr::only($data, $fields);
    }

    public function base(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $data = [
            'uuid' => $this->uuid,
            'is_due' => $this->is_due,
            'is_over' => $this->is_over,
            'title' => $this->title,
            'deadline' => $this->deadline?->format('Y-m-d'),
            'deadline_formated' => $this->deadline?->format('d/m'),
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

        $data = [
            'responsible' => $user->base(),
        ];

        return $this->filterFields($data, $fields);
    }
}
