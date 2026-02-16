<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class UserBaseResource extends JsonResource
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
            'slug' => $this->slug,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'avatar' => $this->avatar,
        ];

        return $this->filterFields($data, $fields);
    }

    public function about(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }

        $data = [
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'bibliography' => $this->bibliography,
        ];

        return $this->filterFields($data, $fields);
    }

    public function location(array $fields = []): array
    {
        if (!$this->resource) {
            return [];
        }
        
        $data = [
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ];

        return $this->filterFields($data, $fields);
    }
}
