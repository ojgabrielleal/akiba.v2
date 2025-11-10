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

    public function userExternalLinks()
    {
        return $this->hasMany(UserExternalLink::class, 'user_id');
    }

    
    public function userLikes()
    {
        return $this->hasMany(UserLike::class, 'user_id');
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'user_id');
    }
}
