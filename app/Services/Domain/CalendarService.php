<?php

namespace App\Services\Domain;
use App\Models\Calendar;

class CalendarService
{
    public function list($options = [])
    {
        $calendarQuery = Calendar::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $calendarQuery->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $calendarQuery->limit($options['limit']);
        }

        if(!empty($options['filters'])){
            foreach ($options['filters'] as $field => $value) {
                $calendarQuery->where($field, $value);
            }
        }

        if(!empty($options['filters']['or'])){
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $calendarQuery->where($value);
                } else {
                    $calendarQuery->orWhere($value);
                }
            }
        }
        
        if(!empty($options['relations'])){
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id'; 
                $calendarQuery->with([$relation => fn($q) => $q->select($cols)]);
            } 
        }

        return $calendarQuery->get();
    }
}