<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Onair extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'onair';

    protected $fillable = [
        'uuid',
        'is_live',
        'program_id',
        'program_type',
        'phrase',
        'type',
        'image',
        'allows_song_requests',
        'song_requests_total'
    ];

    protected $casts = [
        'allows_song_requests' => 'boolean',
        'is_live' => 'boolean'
    ];

    protected $hidden = [
        'show_id'
    ];

    /**
     * Determine the columns that should receive a unique identifier.
     *
     * This method specifies that the 'uuid' column should be automatically 
     * generated as a sortable, unique identifier when the model is created.
     *
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

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
