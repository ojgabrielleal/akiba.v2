<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSocial extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'name',
        'url',
    ];

    protected $hidden = [
        'user_id'
    ];
}
