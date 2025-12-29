<?php

namespace App\Services\Domain;

use Illuminate\Support\Str;
use App\Exceptions\AlreadyExistsException;
use App\Services\Process\ImageService;
use App\Models\Podcast;

class PodcastService
{
    public function list($options = [])
    {
        $podcastQuery = Podcast::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $podcastQuery->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $podcastQuery->limit($options['limit']);
        }

        if(!empty($options['filters'])){
            foreach ($options['filters'] as $field => $value) {
                $podcastQuery->where($field, $value);
            }
        }

        if(!empty($options['filters']['or'])){
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $podcastQuery->where($value);
                } else {
                    $podcastQuery->orWhere($value);
                }
            }
        }
        
        if(!empty($options['relations'])){
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id'; 
                $podcastQuery->with([$relation => fn($q) => $q->select($cols)]);
            } 
        }

        return $podcastQuery->paginate(5);
    }

    public function get($podcastSlug, $options = [])
    {        
        $podcastQuery = Podcast::query();

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

        return $podcastQuery->where('slug', $podcastSlug)->firstOrFail();
    }

    public function create($logged = [], $data = [])
    {
        $exists = Podcast::where('season', $data['season'])->where('episode', $data['episode'])->exists();
        if($exists) throw new AlreadyExistsException();

        $image = new ImageService();

        $podcastCreate = Podcast::create([
            'user_id' => $logged['id'],
            'slug' => Str::slug($data['title']),
            'image' => $image->upload('podcasts', $data['image']),
            'season' => $data['season'],
            'episode' => $data['episode'],
            'title' => $data['title'], 
            'summary' => $data['summary'], 
            'description' => $data['description'],
            'audio' => $data['audio']
        ]);

        return $podcastCreate;
    }

    public function update($podcastId, $data = [])
    {
        $image = new ImageService();

        $podcastQuery = Podcast::findOrFail($podcastId);
        $podcastUpdate = $podcastQuery->update([  
            'slug' => Str::slug($data['title']),
            'image' => $data['image'] ? $image->upload('podcasts', $data['image'], 'public', $podcastQuery->image) : $podcastQuery->image,
            'season' => $data['season'],
            'episode' => $data['episode'],
            'title' => $data['title'],
            'summary' => $data['summary'],
            'description' => $data['description'],
            'audio' => $data['audio'],
        ]);

        return $podcastUpdate;
    }

    public function deactivate($podcastId)
    {
        $podcast = Podcast::findOrFail($podcastId);
        $podcast->update([
            'active' => false
        ]);

        return $podcast;
    }
}