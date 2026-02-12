<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class Calendar extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'calendar';
    
    protected $fillable = [
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
