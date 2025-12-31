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

        if (!empty($options['filters'])) {
            foreach ($options['filters'] as $field => $value) {
                $activityQuery->where($field, $value);
            }
        }

        if (!empty($options['filters']['or'])) {
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $activityQuery->where($value);
                } else {
                    $activityQuery->orWhere($value);
                }
            }
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
