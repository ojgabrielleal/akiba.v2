<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class UserSocial extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'users_socials';
    
    protected $fillable = [
        'user_id',
        'name',
        'url',
    ];

    protected $hidden = [
        'user_id'
    ];
}
