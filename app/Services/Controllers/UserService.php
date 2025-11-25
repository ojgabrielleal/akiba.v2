<?php

namespace App\Services\Controllers;
use App\Models\User;

class UserService
{
    public function list(array $filters = [], array $options = [])
    {
        $query = User::query();

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $query->select($options['fields']);
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
