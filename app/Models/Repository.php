<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repository extends Model
{
    use HasFactory;

    protected $table = 'repositories';
    
    protected $fillable = [
        'is_active',
        'image',
        'url',
        'type',
        'name',
    ];

    protected $casts = [
        'is_active' => 'boolean'
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
}
