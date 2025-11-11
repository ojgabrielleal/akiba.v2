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
    ];

    protected $casts = [
        'birthday' => 'date:Y-m-d',
    ];

    protected $appends = [
        'highest_role'
    ];

    public function getHighestRoleAttribute()
    {
        $weightRole = [
            "dev" => 10,
            "administrator" => 5,
            "streamer" => 4,
            "writer" => 3,
            "podcaster" => 2,
            "social" => 1
        ];

        $translate = [
            "dev" => $this->gender === "male" ? "Desenvolvedor" : "Desenvolvedora",
            "administrator" => $this->gender === "male" ? "Administrador" : "Administradora",
            "streamer" => $this->gender === "male" ? "Locutor" : "Locutora",
            "writer" => $this->gender === "male" ? "Redator" : "Redatora",
            "chat_moderator" => $this->gender === "male" ? "Moderador" : "Moderadora",
            "podcaster" => "Podcaster",
            "social" => "Social Media"
        ];

        $roles = $this->roles->roles->pluck('name');
        
        if ($roles->isEmpty()) {
            return [
                "name" => null,
                "label" => null
            ];
        }

        $highestRole = $roles->sortByDesc(fn($role) => $weightRole[$role] ?? 0)->first();

        return [
            "name" => $highestRole,
            "label" => $translate[$highestRole] ?? $highestRole
        ];
    }

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
        return $this->belongsToMany(Role::class, 'role_assigned', 'user_id', 'role_id');
    }
}
