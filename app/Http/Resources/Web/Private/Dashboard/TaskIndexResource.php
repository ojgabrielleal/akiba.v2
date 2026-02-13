<?php

namespace App\Http\Resources\Web\Private\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'is_due_or_over' => $this->is_over || $this->is_due,
            'title' => $this->title,
            'content' => $this->content, 
            'deadline' => $this->deadline?->format('d/m')
        ];
    }
}
