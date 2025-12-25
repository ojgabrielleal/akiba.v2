<?php

namespace App\Services\Domain;

use Illuminate\Support\Str;
use App\Services\Process\ImageService;
use App\Models\Post;

class PostService
{
    public function list($options = [])
    {
        $postQuery = Post::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $postQuery->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $postQuery->limit($options['limit']);
        }

        if (!empty($options['filters'])) {
            foreach ($options['filters'] as $field => $value) {
                $postQuery->where($field, $value);
            }
        }

        if (!empty($options['filters']['or'])) {
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $postQuery->where($value);
                } else {
                    $postQuery->orWhere($value);
                }
            }
        }

        if (!empty($options['relations'])) {
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id';
                $postQuery->with([$relation => fn($q) => $q->select($cols)]);
            }
        }

        return $postQuery->paginate(5);
    }

    public function get($postId, $options = [])
    {
        $postQuery = Post::query();
        
        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $postQuery->select($options['fields']);
        }

        if (!empty($options['relations'])) {
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id';
                $postQuery->with([$relation => fn($q) => $q->select($cols)]);
            }
        }
        return $postQuery->findOrFail($postId);
    }

    public function create($authenticated = [], $data = [])
    {
        $image = new ImageService();

        $postCreate = Post::create([
            'user_id' => $authenticated['user']->id,
            'slug' => Str::slug($data['title']),
            'title' => $data['title'],
            'content' => $data['content'],
            'status' => $data['status'],
            'image' => $image->upload('posts', $data['image']),
            'cover' => $image->upload('posts', $data['cover']),
        ]);

        $references = [
            ['name' => $data['first_reference_name'], 'url' => $data['first_reference_url']],
            ['name' => $data['second_reference_name'], 'url' => $data['second_reference_url']],
        ];

        $categories = [
            $data['first_category'],
            $data['second_category'],
        ];

        foreach ($references as $item) {
            $postCreate->references()->create([
                'name' => $item['name'],
                'url' => $item['url'],
            ]);
        }

        foreach ($categories as $item) {
            $postCreate->categories()->create([
                'category_name' => $item,
            ]);
        }

        return $postCreate;
    }

    public function update($postId, $data = [])
    {
        $image = new ImageService();

        $postQuery = Post::findOrFail($postId);
        $postUpdate = $postQuery->update([
            'slug' =>  Str::slug($data['title']),
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => $data['image'] ? $image->upload('posts', $data['image'], 'public', $postQuery->image) : $postQuery->image,
            'cover' => $data['cover'] ? $image->upload('posts', $data['cover'], 'public', $postQuery->cover) : $postQuery->cover,
        ]);

        $categories = [
            $data['first_category'],
            $data['second_category']
        ];

        $references = [
            [
                'name' => $data['first_reference_name'],
                'url' => $data['first_reference_url']
            ],
            [
                'name' => $data['second_reference_name'],
                'url' => $data['second_reference_url']
            ],
        ];

        foreach ($categories as $index => $item) {
            $postUpdate->categories()->where('id', $postQuery->categories[$index]->id)->update([
                'category_name' => $item
            ]);
        }

        foreach ($references as $index => $item) {
            $postUpdate->references()->where('id', $postQuery->references[$index]->id)->update([
             'name' => $item['name'],
             'url' => $item['url']
            ]);
        }
    }
}
