<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    protected $table = 'users_social';

    protected $fillable = [
        'user_id',
        'name',
        'url',
    ];

    protected $hidden = [
        'user_id'
    ];
}
