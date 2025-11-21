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
        'is_active',
        'slug',
        'username',
        'password',
        'name',
        'nickname',
        'gender',
        'avatar',
        'birthday',
        'city',
        'state',
        'country',
        'bibliography',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'birthday' => 'date',
    ];

    public function userSocial()
    {
        return $this->hasMany(UserSocial::class, 'user_id');
    }

    
    public function userPreference()
    {
        return $this->hasMany(UserPreference::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'roles_pivot', 'user_id', 'role_id');
    }
}
