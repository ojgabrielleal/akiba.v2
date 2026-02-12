<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class Poll extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'polls';
    
    protected $fillable = [
        'is_active',
        'question',
    ];

    protected $casts = [
        'is_active' => 'boolean',
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
    public function options()
    {
        return $this->hasMany(PollOption::class, 'poll_id');
    }
}
