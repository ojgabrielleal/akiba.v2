<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'slug',
        'username',
        'password',
        'name',
        'nickname',
        'gender',
        'avatar',
        'email',
        'birthday',
        'city',
        'state',
        'country',
        'bibliography',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    protected $casts = [
        'birthday' => 'date:Y-m-d',
        'password' => 'hashed',
    ];

    protected $with = [
        'permissions', 
        'externalLinks',
        'likes'
    ];

    protected $appends = ['permissions_keys'];
    
    /**
    * Set accessor 'permissions_keys' in response
    */
    public function getPermissionsKeysAttribute()
    {
        $permissions = $this->getRelationValue('permissions');
        return $permissions ? $permissions->pluck('permission') : collect();
    }

    /**
     * Relationships from models 'UsersExternalLink' and 'UsersPermissions'
     */
    public function userExternalLinks()
    {
        return $this->hasMany(UserExternalLink::class, 'user_id');
    }

    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class, 'user_id');
    }
}
