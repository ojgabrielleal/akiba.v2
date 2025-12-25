<?php

namespace App\Services\Domain;
use App\Models\ShowSchedule;

class ShowScheduleService
{
    public function list($options = [])
    {
        $showSchedule = ShowSchedule::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $showSchedule->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $showSchedule->limit($options['limit']);
        }

        if (!empty($options['filters'])) {
            foreach ($options['filters'] as $field => $value) {
                $showSchedule->where($field, $value);
            }
        }

        if (!empty($options['filters']['or'])) {
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $showSchedule->where($value);
                } else {
                    $showSchedule->orWhere($value);
                }
            }
        }

        if (!empty($options['relations'])) {
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id';
                $showSchedule->with([$relation => fn($q) => $q->select($cols)]);
            }
        }

        return $showSchedule->paginate(5);
    }
}