<?php

namespace App\Services\Domain;

use Illuminate\Support\Str;
use App\Exceptions\AlreadyExistsException;
use App\Services\Process\ImageService;
use App\Models\Show;

class ShowService
{
    public function list($options = [])
    {
        $showQuery = Show::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $showQuery->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $showQuery->limit($options['limit']);
        }

        if(!empty($options['filters'])){
            foreach ($options['filters'] as $field => $value) {
                $showQuery->where($field, $value);
            }
        }

        if(!empty($options['filters']['or'])){
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $showQuery->where($value);
                } else {
                    $showQuery->orWhere($value);
                }
            }
        }
        
        if(!empty($options['relations'])){
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id'; 
                $showQuery->with([$relation => fn($q) => $q->select($cols)]);
            } 
        }

        return $showQuery->get();
    }

    public function get($showId, $options = [])
    {
        $showQuery = Show::query();
        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $showQuery->select($options['fields']);
        }

        if (!empty($options['relations'])) {
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id';
                $showQuery->with([$relation => fn($q) => $q->select($cols)]);
            }
        }
        return $showQuery->findOrFail($showId);
    }

    public function create($authenticated = [], $data = [])
    {
        $exist = Show::where('name', $data['name'])->exists();
        if ($exist) throw new AlreadyExistsException();

        $image = new ImageService();

        $showCreate = Show::create([
            'user_id' => $data['user_id'] ? $data['user_id'] : $authenticated['id'],
            'slug' => Str::slug($data['name']),
            'name' => $data['name'],
            'image' => $image->upload('shows', $data['image'], 'public'),
            'is_all' => $data['is_all'],
            'has_schedule' => $data['has_schedule']
        ]);

        if($data['has_schedule']){
            foreach ($data['schedules'] as $schedule) {
                $showCreate->schedules()->create([
                    'day' => $schedule['day'],
                    'time' => $schedule['time'],
                ]);
            }
        }

        return $showCreate;
    }

    public function update($showId, $data = [])
    {
        $image = new ImageService();

        $showQuery = Show::findOrFail($showId);
        $showUpdate = $showQuery->update([
            'user_id' => $data['user_id'] ? $data['user_id'] : $showQuery->user_id,
            'slug' => $data['name'] !== $showQuery->name ? Str::slug($data['name']) : $showQuery->slug,
            'name' => $data['name'],
            'image' => $data['image'] ? $image->upload('shows', $data['image'], 'public', $showQuery->image) : $showQuery->image,
            'is_all' => $data['is_all'],
            'has_schedule' => $data['has_schedule'],
        ]);

        if($data['has_schedule']){
            $showQuery->schedules()->delete();
            foreach ($data['schedules'] as $schedule) {
                $showQuery->schedules()->create([
                    'day' => $schedule['day'],
                    'time' => $schedule['time'],
                ]);
            }
        }

        return $showUpdate;
    }

    public function deactivate($showId)
    {
        $showQuery = Show::findOrFail($showId);
        $showDeactivate = $showQuery->update([
            'is_active' => false
        ]);

        return $showDeactivate;
    }
}