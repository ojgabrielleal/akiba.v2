<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendar';

    protected $fillable = [
        'user_id',
        'hour',
        'day',
        'category',
        'content',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $casts = [
        'hour' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
