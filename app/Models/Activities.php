<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'user_id',
        'is_activity',
        'title',
        'content',
        'limite_confirm'
    ];

    protected $casts = [
        'is_activity' => 'boolean',
        'limit_confirm' => 'date'
    ];

    protected $hidden = [
        'user_id',
    ];
    
    public function activitiesConfirmations()
    {
        return $this->hasMany(ActivitiesConfirmations::class, 'activiti');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
