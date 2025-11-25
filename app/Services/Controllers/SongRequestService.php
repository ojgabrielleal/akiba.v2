<?php

namespace App\Services\Controllers;
use App\Models\SongRequest;
use App\Models\Onair;

class SongRequestService
{
    public function list(array $filters = [], array $options = [])
    {
        $query = SongRequest::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $query->select($options['fields']);
        }

        if (!empty($filters['live'])) {
            $onair = Onair::where('is_live', true)->firstOrFail();
            $query->where('onair_id', $onair->id);
        }

        $with = [];
        if (!empty($options['relations'])) {
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) {
                    $cols[] = 'id'; 
                }
                $with[$relation] = fn($q) => $q->select($cols);
            }
        }

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->get();
    }
}