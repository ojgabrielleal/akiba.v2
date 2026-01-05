<?php

namespace App\Services\Domain;
use App\Models\Task;

class TaskService
{
    public function list($options = [])
    {
        $taskQuery = Task::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $taskQuery->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $taskQuery->limit($options['limit']);
        }

        if (!empty($options['filters']) && is_array($options['filters'])) {
            foreach ($options['filters'] as $field => $value) {
                if ($field === 'or') {
                    continue;
                }

                if (is_array($value)) {
                    continue;
                }

                $taskQuery->where($field, $value);
            }
        }

        if (!empty($options['filters']['or'])) {
            $taskQuery->where(function ($q) use ($options) {
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
                    $taskQuery->with($relation);
                    continue;
                }
                if (!in_array('id', $cols)) {
                    $cols[] = 'id';
                }
                $taskQuery->with([
                    $relation => fn($q) => $q->select($cols)
                ]);
            }
        }

        return $taskQuery->get();
    }

    public function markAsCompleted($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->update([
            'is_completed' => true
        ]);

        return true;
    }
}