<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    
    protected $fillable = [
        'user_id',
        'is_active',
        'image',
        'slug',
        'title',
        'content',
        'cover',
        'type'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $hidden = [
        'user_id',
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

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function references()
    {
        return $this->hasMany(PostReference::class, 'post_id');
    }
    
    public function reactions()
    {
        return $this->hasMany(PostReaction::class, 'post_id');
    }
    
    public function categories()
    {
        return $this->hasMany(PostCategory::class, 'post_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
