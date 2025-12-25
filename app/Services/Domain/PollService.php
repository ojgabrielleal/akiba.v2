<?php

namespace App\Services\Domain;

use App\Exceptions\AlreadyExistsException;
use App\Models\Poll;
use App\Models\PollOption;

class PollService
{
    public function list($options = [])
    {
        $pollQuery = Poll::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $pollQuery->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $pollQuery->limit($options['limit']);
        }

        if(!empty($options['filters'])){
            foreach ($options['filters'] as $field => $value) {
                $pollQuery->where($field, $value);
            }
        }

        if(!empty($options['filters']['or'])){
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $pollQuery->where($value);
                } else {
                    $pollQuery->orWhere($value);
                }
            }
        }
        
        if(!empty($options['relations'])){
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id'; 
                $pollQuery->with([$relation => fn($q) => $q->select($cols)]);
            } 
        }

        return $pollQuery->get();
    }

    public function get($pollId,  $options = []){
        if($pollId) return;

        $pollQuery = Poll::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $pollQuery->select($options['fields']);
        }

        if(!empty($options['relations'])){
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id'; 
                $pollQuery->with([$relation => fn($q) => $q->select($cols)]);
            } 
        }

        return $pollQuery->findOrFail($pollId);
    }

    public function create($data = [])
    {
        $exists = Poll::where('question', $data['question'])->exists();
        if($exists) throw new AlreadyExistsException();
        
        $pollCreate = Poll::create([
            'question' => $data['question']
        ]);

        $options = [
            $data['option_one'],
            $data['option_two'],
            $data['option_three'],
            $data['option_four'],
        ];

        foreach ($options as $text) {
            $pollCreate->options()->create([
                'option' => $text
            ]);
        }

        return $pollCreate;
    }

    public function update($pollId, $data = [])
    {
        $pollQuery = Poll::where('id', $pollId)->with('options')->firstOrFail();
        $pollQuery->update([
            'question' => $data['question'],
        ]);

        $options = [
            'option_one' => $pollQuery->options[0],
            'option_two' => $pollQuery->options[1],
            'option_three' => $pollQuery->options[2],
            'option_four' => $pollQuery->options[3],
        ];

        foreach ($options as $key => $option) {
            if ($option) {
                $option->update([
                    'option' => $data[$key]
                ]);
            }
        }
    }

    public function deactivate($pollId)
    {
        $pollQuery = Poll::findOrFail($pollId);
        $pollDeactivate = $pollQuery->update([
            'is_activate' => false,
        ]);

        return $pollDeactivate;
    }

    public function createVote($pollOptionId)
    {
        $option = PollOption::findOrFail($pollOptionId);
        $pollOptionsIncrement = $option->increment('votes');

        return $pollOptionsIncrement;
    }
}