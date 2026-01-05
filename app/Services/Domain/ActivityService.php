<?php

namespace App\Services\Domain;

use App\Models\Activity;

class ActivityService
{
    public function list($options = [])
    {
        $activityQuery = Activity::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $activityQuery->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $activityQuery->limit($options['limit']);
        }

        if (!empty($options['filters']) && is_array($options['filters'])) {
            foreach ($options['filters'] as $field => $value) {
                if ($field === 'or') {
                    continue;
                }

                if (is_array($value)) {
                    continue;
                }

                $activityQuery->where($field, $value);
            }
        }

        if (!empty($options['filters']['or'])) {
            $activityQuery->where(function ($q) use ($options) {
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
                    $activityQuery->with($relation);
                    continue;
                }
                if (!in_array('id', $cols)) {
                    $cols[] = 'id';
                }
                $activityQuery->with([
                    $relation => fn($q) => $q->select($cols)
                ]);
            }
        }

        return $activityQuery->get();
    }

    public function createConfirmation($logged = [], $activityId)
    {
        $activityQuery = Activity::findOrFail($activityId);
        return $activityQuery->confirmations()->create([
            'user_id' => $logged['id'],
        ]);
    }
}
