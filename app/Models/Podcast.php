<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Podcast extends Model
{
    use HasFactory;

    protected $table = 'podcasts';
    
    protected $fillable = [
        'is_active',
        'slug',
        'user_id',
        'title',
        'image',
        'season',
        'episode',
        'summary',
        'description',
        'audio'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $hidden = [
        'user_id'
    ];
    
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn($value, $attributes) => Str::slug($attributes['title'] ?? $value)
        );
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
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
