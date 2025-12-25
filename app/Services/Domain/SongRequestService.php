<?php

namespace App\Services\Domain;

use App\Models\SongRequest;
use App\Models\Onair;

class SongRequestService
{
    public function list($options = [])
    {
        $songRequestQuery = SongRequest::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $songRequestQuery->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $songRequestQuery->limit($options['limit']);
        }

        if(!empty($options['filters'])){
            foreach ($options['filters'] as $field => $value) {
                $songRequestQuery->where($field, $value);
            }
        }

        if(!empty($options['filters']['or'])){
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $songRequestQuery->where($value);
                } else {
                    $songRequestQuery->orWhere($value);
                }
            }
        }
        
        if(!empty($options['relations'])){
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id'; 
                $songRequestQuery->with([$relation => fn($q) => $q->select($cols)]);
            } 
        }


        return $songRequestQuery->get();
    }

    public function setIsPlayed($songRequestId)
    {
        $songRequest = SongRequest::findOrFail($songRequestId);
        $songRequest->update([
            'is_played' => !$songRequest->is_played
        ]);

        return true;
    }

    public function toggleStatus()
    {
        $onair = Onair::where('is_live', true)->firstOrFail();
        $onair->update([
            'song_request_status' => !$onair->song_request_status
        ]);

        return $onair->song_request_status;
    }
}