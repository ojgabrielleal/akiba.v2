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

        if (!empty($options['filters']) && is_array($options['filters'])) {
            foreach ($options['filters'] as $field => $value) {
                if ($field === 'or') {
                    continue;
                }

                if (is_array($value)) {
                    continue;
                }

                $calendarQuery->where($field, $value);
            }
        }

        if (!empty($options['filters']['or'])) {
            $calendarQuery->where(function ($q) use ($options) {
                foreach ($options['filters']['or'] as $condition) {
                    if (count($condition) !== 3) {
                        continue;
                    }

                    [$field, $operator, $value] = $condition;

                    if ($operator === 'IS' && $value === null) {
                        $q->orWhereNull($field);
                    } else {
                        $q->orWhere($field, $operator, $value);
                    }
                }
            });
        }

        if (!empty($options['relations'])) {
            foreach ($options['relations'] as $relation => $cols) {
                if (empty($cols)) {
                    $calendarQuery->with($relation);
                    continue;
                }
                if (!in_array('id', $cols)) {
                    $cols[] = 'id';
                }
                $calendarQuery->with([
                    $relation => fn($q) => $q->select($cols)
                ]);
            }
        }

        return $calendarQuery->get();
    }
}
