<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendar';

    protected $fillable = [
        'user_id',
        'activity_id',
        'start_time',
        'category',
        'content',
    ];

    protected $hidden = [
        'user_id',
        'activity_id',
    ];

    protected $casts = [
        'start_time' => 'datetime',
    ];

    
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
