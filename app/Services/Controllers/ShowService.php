<?php

namespace App\Services\Controllers;
use App\Models\Show;

class ShowService
{
    public function list(array $filters = [], array $options = [])
    {
        $query = Show::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $query->select($options['fields']);
        }

        if (isset($filters['user_only'])) {
            $userId = $filters['user_only'];

            $query->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                ->orWhere('is_all', true);
            });
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