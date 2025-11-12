<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'is_active',
        'user_id',
        'cover',
        'image',
        'slug',
        'title',
        'content',
        'dates',
        'address'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
