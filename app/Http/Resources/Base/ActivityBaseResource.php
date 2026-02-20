<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Base\UserBaseResource;
use App\Traits\ResolvesResourcesFilters;

class ActivityBaseResource extends JsonResource
{
    use ResolvesResourcesFilters;

    public function base(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $data = [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'content' => $this->content,
            'allows_confirmations' => $this->allows_confirmations,
            'limit' => $this->limit?->format('d/m'),
            'limit_formated' => $this->limit?->format('Y-m-d'),
        ];

        return $this->filterFields($data, $fields);
    }

    public function author(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $user = new UserBaseResource($this->author);
        return $this->filterFields($user->base(), $fields);
    }

    public function confirmations(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $data = $this->confirmations->map(fn($item) => [
            'uuid' => $item->uuid,
            'confirmer' => [
                'uuid'     => $item->confirmer->uuid,
                'name'     => $item->confirmer->name,
                'nickname' => $item->confirmer->nickname,
                'avatar'   => $item->confirmer->avatar,
            ],
        ]);

        return $data->map(function ($item) use ($fields) {
            return $this->filterFields($item, $fields);
        })->toArray();
    }
}
