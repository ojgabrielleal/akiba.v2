<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'user_id',
        'is_activity',
        'activity_limit',
        'title',
        'content',
    ];

    protected $casts = [
        'activity_limit' => 'date',
        'is_activity' => 'boolean',
    ];

    protected $hidden = [
        'user_id',
    ];
    
    public function activitiesConfirmations()
    {
        return $this->hasMany(ActivityConfirmation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
