<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLike extends Model
{
    protected $table = 'users_likes';

    protected $fillable = [
        'user_id',
        'category',
        'content'
    ];

    protected $hidden = [
        'user_id'
    ];

    /**
     * Relationship from model 'Users'
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
