<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $table = 'users_likes';

    protected $fillable = [
        'user_id',
        'is_like',
        'content'
    ];

    protected $casts = [
        'is_like' => 'boolean'
    ];

    protected $hidden = [
        'user_id'
    ];
}
