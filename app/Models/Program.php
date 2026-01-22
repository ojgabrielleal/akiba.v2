<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';
    
    protected $fillable = [
        'is_active',
        'user_id',
        'slug',
        'name',
        'image',
        'allow_all',
        'has_schedule'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'allow_all' => 'boolean'
    ];

    protected $hidden = [
        'user_id',
    ];

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn($value, $attributes) => Str::slug($attributes['name'] ?? $value)
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
    public function host()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function schedules()
    {
        return $this->hasMany(ProgramSchedule::class, 'program_id');
    }
    
}
