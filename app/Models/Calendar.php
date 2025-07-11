<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    /**
     * Mutator for content
    */
    public function getHourAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    /**
     * Relationship with the 'Users' model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
