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

    protected $appends = ['styles'];

    /**
     * Set accessor 'styles' in response
    */
    public function getStylesAttribute()
    {
        $colors = [
            'live' => 'var(--color-purple-mystic)',
            'video' => 'var(--color-red-crimson)',
            'podcast' => 'var(--color-green-forest)',
            'show' => 'var(--color-blue-skywave)',
        ];

        return [
            'bg' => $colors[$this->category] ?? 'var(--color-blue-skywave)',
        ];
    }

    /**
     * Mutator for content
    */
    public function getHourAttribute($value)
    {
        return Carbon::parse($value)->format('H\Hi');
    }

    /**
     * Relationship with the 'Users' model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
