<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Base\UserBaseResource;
use App\Traits\ResolvesResourcesFilters;

class PostBaseResource extends JsonResource
{
    use ResolvesResourcesFilters;

    public function base(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $data = [
            'uuid' => $this->uuid,
            'status' => $this->status,
            'title' => $this->title,
            'image' => $this->image,
            'cover' => $this->cover,
            'content' => $this->content
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

    public function references(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $data = $this->references->map(fn($item) => [
            'uuid' => $item->uuid,
            'site' => $item->name,
            'url' => $item->url
        ]);

        return $data->map(function ($item) use ($fields) {
            return $this->filterFields($item, $fields);
        })->toArray();
    }

    public function reactions(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $data = $this->reactions->map(fn($item) => [
            'uuid' => $item->uuid,
            'reaction' => $item->name
        ]);

        return $data->map(function ($item) use ($fields) {
            return $this->filterFields($item, $fields);
        })->toArray();
    }

    public function categories(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $data = $this->categories->map(fn($item) => [
            'uuid' => $item->uuid,
            'category' => $item->name,
        ]);

        return $data->map(function ($item) use ($fields) {
            return $this->filterFields($item, $fields);
        })->toArray();
    }
}
