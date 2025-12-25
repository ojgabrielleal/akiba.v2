<?php

namespace App\Services\Domain;

use Illuminate\Support\Str;
use App\Services\Process\ImageService;
use App\Models\Review;

class ReviewService
{
    public function list($options = [])
    {
        $reviewQuery = Review::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $reviewQuery->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $reviewQuery->limit($options['limit']);
        }

        if (!empty($options['filters'])) {
            foreach ($options['filters'] as $field => $value) {
                $reviewQuery->where($field, $value);
            }
        }

        if (!empty($options['filters']['or'])) {
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $reviewQuery->where($value);
                } else {
                    $reviewQuery->orWhere($value);
                }
            }
        }

        if (!empty($options['relations'])) {
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id';
                $reviewQuery->with([$relation => fn($q) => $q->select($cols)]);
            }
        }

        return $reviewQuery->get();
    }

    public function get($reviewSlug, $options = [])
    {
        $reviewQuery = Review::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $reviewQuery->select($options['fields']);
        }

        if (!empty($options['relations'])) {
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id';
                $reviewQuery->with([$relation => fn($q) => $q->select($cols)]);
            }
        }
        return $reviewQuery->where('slug', $reviewSlug)->firstOrFail();
    }

    public function create($authenticated = [], $data = [])
    {
        $image = new ImageService();

        $reviewCreate = Review::create([
            'slug' => Str::slug($data['title']),
            'title' => $data['title'],
            'sinopse' => $data['sinopse'],
            'image' => $image->upload('reviews', $data['image']),
            'cover' => $image->upload('reviews', $data['cover']),
        ]);

        if ($reviewCreate) {
            $reviewCreate->reviews()->create([
                'user_id' => $authenticated['id'],
                'content' => $data['content'],
            ]);
        }

        return $reviewCreate;
    }

    public function update($reviewId, $data = [])
    {
        $image = new ImageService();

        $reviewQuery = Review::findOrFail($reviewId);
        $reviewUpdate = $reviewQuery->update([
            'slug' => Str::slug($data['title']),
            'title' => $data['title'],
            'sinopse' => $data['sinopse'],
            'image' => $data['image'] ? $image->upload('reviews', $data['image'], 'public', $reviewQuery->image) : $reviewQuery->image,
            'cover' => $data['cover'] ? $image->upload('reviews', $data['cover'], 'public', $reviewQuery->cover) : $reviewQuery->cover,
        ]);

        if( $reviewUpdate ) {
            $reviewQuery->reviews()->updateOrCreate(
                ['user_id' => $data['user_id']],
                ['content' => $data['content']]
            );
        }

        return $reviewUpdate;
    }
}
