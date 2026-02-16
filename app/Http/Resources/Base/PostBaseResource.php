<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

use App\Http\Resources\Base\UserBaseResource;

class PostBaseResource extends JsonResource
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

        $authorData = $user->base();
        if (!empty($fields)) {
            $authorData = Arr::only($authorData, $fields);
        }

        return [
            'author' => $authorData,
        ];
    }

    public function references(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $data = [
            'references' => $this->references->map(fn($item) => [
                'uuid' => $item->uuid,
                'site' => $item->name,
                'url' => $item->url
            ])
        ];

        if (!empty($fields)) {
            $data['references'] = $data['references']->map(function ($item) use ($fields) {
                return Arr::only($item, $fields);
            });
        }

        return $data;
    }

    public function reactions(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $data = [
            'reactions' => $this->reactions->map(fn($item) => [
                'uuid' => $item->uuid,
                'reaction' => $item->name
            ])
        ];

        if (!empty($fields)) {
            $data['reactions'] = $data['reactions']->map(function ($item) use ($fields) {
                return Arr::only($item, $fields);
            });
        }

        return $data;
    }

    public function categories(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $data = [
            'categories' => $this->categories->map(fn($item) => [
                'uuid' => $item->uuid,
                'category' => $item->category,
            ])
        ];

        if (!empty($fields)) {
            $data['categories'] = $data['categories']->map(function ($item) use ($fields) {
                return Arr::only($item, $fields);
            });
        }

        return $data;
    }
}
