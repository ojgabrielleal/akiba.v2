<?php

namespace App\Services\Domain;

use Illuminate\Support\Str;
use App\Exceptions\AlreadyExistsException;
use App\Services\Process\ImageService;
use App\Models\Event;

class EventService
{
    public function list($options = [])
    {
        $eventQuery = Event::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $eventQuery->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $eventQuery->limit($options['limit']);
        }

        if(!empty($options['filters'])){
            foreach ($options['filters'] as $field => $value) {
                $eventQuery->where($field, $value);
            }
        }

        if(!empty($options['filters']['or'])){
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $eventQuery->where($value);
                } else {
                    $eventQuery->orWhere($value);
                }
            }
        }
        
        if(!empty($options['relations'])){
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id'; 
                $eventQuery->with([$relation => fn($q) => $q->select($cols)]);
            } 
        }

        return $eventQuery->paginate(5);
    }

    public function get($eventSlug)
    {        
        $podcastQuery = Event::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $podcastQuery->select($options['fields']);
        }
        
        if(!empty($options['relations'])){
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id'; 
                $podcastQuery->with([$relation => fn($q) => $q->select($cols)]);
            } 
        }
        return $podcastQuery->where('slug', $eventSlug)->firstOrFail();
    }

    public function create($logged = [], $data = [])
    {
        $exists = Event::where('title', $data['title'])->exists();
        if($exists) throw new AlreadyExistsException();

        $image = new ImageService();

        $eventCreate = Event::create([
            'user_id' => $logged['id'],
            'slug' => Str::slug($data['title']),
            'image' => $image->upload('events', $data['image']),
            'cover' => $image->upload('events', $data['cover']),
            'title' => $data['title'],
            'content' => $data['content'],
            'dates' => $data['dates'],
            'address' => $data['address']
        ]);

        return $eventCreate;
    }

    public function update($eventId, $data = [])
    {
        $image = new ImageService();

        $event = Event::findOrFail($eventId);
        $eventUpdate = $event->update([
            'slug' => Str::slug($data['title']),
            'image' => $data['image'] ? $image->upload('events', $data['image'], 'public', $event->image) : $event->image,
            'cover' => $data['cover'] ? $image->upload('events', $data['cover'], 'public', $event->cover) : $event->cover,
            'title' => $data['title'],
            'content' => $data['content'],
            'dates' => $data['dates'],
            'address' => $data['address'],
        ]);

        return $eventUpdate;
    }

    public function deactivate($eventId)
    {
        $eventQuery = Event::findOrFail($eventId);
        $eventDeactivate = $eventQuery->update([
            'is_active' => false,
        ]);

        return $eventDeactivate;
    }
}