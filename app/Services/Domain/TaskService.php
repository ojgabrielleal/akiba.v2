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

        if(!empty($options['filters'])){
            foreach ($options['filters'] as $field => $value) {
                $taskQuery->where($field, $value);
            }
        }

        if(!empty($options['filters']['or'])){
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $taskQuery->where($value);
                } else {
                    $taskQuery->orWhere($value);
                }
            }
        }
        
        if(!empty($options['relations'])){
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id'; 
                $taskQuery->with([$relation => fn($q) => $q->select($cols)]);
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