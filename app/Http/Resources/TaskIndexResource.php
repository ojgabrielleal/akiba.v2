<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'is_due' => $this->is_due || $this->is_over,
            'title' => $this->title,
            'dead_line' => $this->dead_line?->format('d/m'),
            'content' => $this->content,
        ];
    }
}
