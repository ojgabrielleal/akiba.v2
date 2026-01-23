<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Onair extends Model
{
    use HasFactory;

    protected $table = 'onair';
    
    protected $fillable = [
        'is_live',
        'show_id',
        'show_type',
        'phrase',
        'type',
        'image',
        'allows_songs_requests',
        'song_request_count'
    ];

    protected $casts = [
        'is_live' => 'boolean'
    ];

    protected $hidden = [
        'show_id'
    ];

    /**
     * Query scopes for this model.
     *
     * These methods define reusable query filters that can be
     * applied to Eloquent queries (e.g., active()).
     */
    public function scopeLive($query)
    {
        return $query->where('is_live', true);
    }

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function program()
    {
        return $this->morphTo();
    }
}
