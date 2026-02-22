<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Calendar extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'calendar';

    protected $fillable = [
        'uuid',
        'is_active',
        'has_activity',
        'user_id',
        'activity_id',
        'time',
        'date',
        'category',
        'content',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'has_activity' => 'boolean',
        'date' => 'date:Y-m-d',
        'time' => 'date:h:i',
    ];

    protected $hidden = [
        'user_id',
        'activity_id',
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
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
