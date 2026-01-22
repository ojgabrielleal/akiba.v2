<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SongRequest extends Model
{
    use HasFactory;

    protected $table = 'songs_requests';
    
    protected $fillable = [
        'is_played',
        'is_canceled',
        'onair_id',
        'music_id',
        'ip',
        'name',
        'address',
        'message',
    ];

    protected $hidden = [
        'onair_id',
        'music_id'
    ];

    protected $casts = [
        'is_played' => 'boolean',
        'is_canceled' => 'boolean'
    ];

        /**
     * Query scopes for this model.
     *
     * These methods define reusable query filters that can be
     * applied to Eloquent queries (e.g., active()).
     */
    public function scopePlayed($query)
    {
        return $query->where('is_played', true);
    }

    public function scopeQueued($query)
    {
        return $query->where('is_played', false);
    }

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function onair()
    {
        return $this->belongsTo(Onair::class, 'onair_id');
    }
    
    public function music()
    {
        return $this->belongsTo(Music::class, 'music_id');
    }
}
