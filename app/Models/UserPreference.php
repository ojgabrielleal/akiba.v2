<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class UserPreference extends Model
{
    use HasFactory, HasUuid;
    
    protected $table = 'users_preferences';

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
