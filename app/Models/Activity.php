<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class Activity extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'activities';

    protected $fillable = [
        'allows_confirmations',
        'user_id',
        'limit',
        'title',
        'content',
    ];

    protected $casts = [
        'allows_confirmations' => 'boolean',
        'limit' => 'date:Y-m-d',
    ];

    protected $hidden = [
        'user_id',
    ];
    
    /**
     * Query scopes for this model.
     *
     * These methods define reusable query filters that can be
     * applied to Eloquent queries (e.g., active()).
     */
    public function scopeValid($query)
    {
        return $query->where('limit', '>=', today());
    }

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function confirmations()
    {
        return $this->hasMany(ActivityParticipants::class, 'activity_id');
    }

}
