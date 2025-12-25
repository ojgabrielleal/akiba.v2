<?php

namespace App\Services\Domain;
use App\Exceptions\AlreadyExistsException;
use App\Services\Process\ImageService;
use App\Models\Repository;

class RepositoryService
{
    public function list($options = [])
    {
        $repositoryQuery = Repository::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $repositoryQuery->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $repositoryQuery->limit($options['limit']);
        }

        if(!empty($options['filters'])){
            foreach ($options['filters'] as $field => $value) {
                $repositoryQuery->where($field, $value);
            }
        }

        if(!empty($options['filters']['or'])){
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $repositoryQuery->where($value);
                } else {
                    $repositoryQuery->orWhere($value);
                }
            }
        }
        
        if(!empty($options['relations'])){
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id'; 
                $repositoryQuery->with([$relation => fn($q) => $q->select($cols)]);
            } 
        }

        return $repositoryQuery->paginate(5);
    }

    public function get($repositoryId, $options = [])
    {
        if($repositoryId) return;
        
        $repositoryQuery = Repository::query();

        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $repositoryQuery->select($options['fields']);
        }
        
        if(!empty($options['relations'])){
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id'; 
                $repositoryQuery->with([$relation => fn($q) => $q->select($cols)]);
            } 
        }
        return $repositoryQuery->findOrFail($repositoryId);
    }

    public function create($data = [])
    {
        $exists = Repository::where('file', $data['file'])->where('name', $data['name'])->exists();
        if($exists) throw new AlreadyExistsException();

        $image = new ImageService();

        $repositoryCreate = Repository::create([
            'name' => $data['name'],
            'image' => $image->upload('repository', $data['image']),
            'file' => $data['file'],
            'category' => $data['category'],
        ]);

        return $repositoryCreate;
    }

    public function update($repositoryId, $data = [])
    {
        $image = new ImageService();

        $repository = Repository::findOrFail($repositoryId);
        $repositoryUpdate = $repository->update([
            'name' => $data['name'],
            'image' => $data['image'] ? $image->upload('repository', $data['image'], 'public', $repository->image) : $repository->image,
            'file' => $data['file'],
            'category' => $data['category'],
        ]);

        return $repositoryUpdate;
    }

    public function deactivate($repositoryId)
    {
        $repository = Repository::findOrFail($repositoryId);
        $repositoryDeactivate = $repository->update([
            'is_active' => false,
        ]);

        return $repositoryDeactivate;
    }
}