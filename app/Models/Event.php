<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'user_id',
        'image',
        'slug',
        'title',
        'content',
        'dates',
        'address'
    ];

    /**
     * Relationship with 'User' model
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
