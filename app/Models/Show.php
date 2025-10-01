<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    protected $table = 'shows';

    protected $fillable = [
        'user_id',
        'slug',
        'name',
        'image',
        'is_all',
    ];

    protected $hidden = [
        'user_id',
    ];

    /**
     * Relationship from model 'Users'
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship from model 'Onair'
     */
    public function onair()
    {
        return $this->morphMany(Onair::class, 'program');
    }

    /**
     * Relationship from model 'ProgramSchedule'
     */
    public function schedules()
    {
        return $this->hasMany(ProgramSchedule::class);
    }
}
