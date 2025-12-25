<?php

namespace App\Services\Domain;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Exceptions\AlreadyExistsException;
use App\Services\Process\ImageService;
use App\Models\User;

class UserService
{
    public function list($options = [])
    {
        $userQuery = User::query();
        
        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $userQuery->select($options['fields']);
        }

        if (!empty($options['limit'])) {
            $userQuery->limit($options['limit']);
        }

        if(!empty($options['filters'])){
            foreach ($options['filters'] as $field => $value) {
                $userQuery->where($field, $value);
            }
        }

        if(!empty($options['filters']['or'])){
            foreach ($options['filters']['or'] as $value) {
                if ($value instanceof \Closure) {
                    $userQuery->where($value);
                } else {
                    $userQuery->orWhere($value);
                }
            }
        }
        
        if(!empty($options['relations'])){
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id'; 
                $userQuery->with([$relation => fn($q) => $q->select($cols)]);
            } 
        }
        
        return $userQuery->get();
    }

    public function get($userSlug, $options = [])
    {
        $userQuery = User::query();
        if (!empty($options['fields'])) {
            if (!in_array('id', $options['fields'])) {
                $options['fields'][] = 'id';
            }
            $userQuery->select($options['fields']);
        }

        if (!empty($options['relations'])) {
            foreach ($options['relations'] as $relation => $cols) {
                if (!in_array('id', $cols)) $cols[] = 'id';
                $userQuery->with([$relation => fn($q) => $q->select($cols)]);
            }
        }
        return $userQuery->where('slug', $userSlug)->first();
    }

    public function create($data = [])
    {
        if (User::where('username', $data['username'])->exists()) {
            throw new AlreadyExistsException();
        }

        $avatar = $data['gender'] === 'male' ? '/img/default/defaultAvatarMale.webp' : '/img/default/defaultAvatarFemale.webp';

        $user = User::create([
            'slug' => Str::slug($data['nickname']),
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'avatar' => $avatar,
            'gender' => $data['gender'],
        ]);
        $user->roles()->attach($data['roles'] ?? []);

        return $user;
    }

    public function update($userId, $data = [])
    {     
        $image = new ImageService();

        $userQuery = User::findOrFail($userId);
        $userUpdate = $userQuery->update([
            'slug' =>  Str::slug($data['nickname']),
            'avatar' => $data['avatar'] ? $image->upload('users', $data['avatar'], 'public', $userQuery->avatar) : $userQuery->avatar,
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'gender' => $data['gender'],
            'birthday' => $data['birthday'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'bibliography' => $data['bibliography'],
        ]);
    
        if($data['external_links']){
            //Removing external links not present in the update data
            $externalLinksExisting = collect($data['external_links'] ?? [])->pluck('id')->filter()->toArray();
            $userQuery->externalLinks()->whereNotIn('id', $externalLinksExisting)->delete();
            
            //Updating or creating external links
            foreach($data['external_links'] as $item){
                if(isset($item['id'])){
                    $userQuery->externalLinks()->where('id', $item['id'])->update([
                        'name' => $item['name'],
                        'url' => $item['url'],
                    ]);
                }else{
                    $userQuery->externalLinks()->create([
                        'name' => $item['name'],
                        'url' => $item['url'],
                    ]);
                }
            }
        }

        if($data['likes']){
            foreach($data['likes'] as $item){
                $userQuery->likes()->where('id', $item['id'])->update([
                    'category' => $item['category'],
                    'content' => $item['content']
                ]);
            }
        }

        return $userUpdate;
    }

    public function disable($userId)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'is_active' => false
        ]);

        return true;
    }

    public function updatePassword($userId, $newPassword)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return true;
    }

    public function updateRoles($userId, $roles = [])
    {
        $user = User::findOrFail($userId);
        $user->roles()->sync($roles);
        return true;
    }

}
