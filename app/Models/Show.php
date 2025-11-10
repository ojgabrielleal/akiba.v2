<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    protected $table = 'shows';

    protected $fillable = [
        'user_id',
        'is_active',
        'slug',
        'name',
        'image',
        'is_all',
        'has_schedule'
    ];

    protected $hidden = [
        'user_id',
    ];

    public function programSchedule()
    {
        return $this->hasMany(ProgramSchedule::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
