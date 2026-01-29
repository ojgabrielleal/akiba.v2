<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'is_active',
        'slug',
        'cover',
        'image',
        'title',
        'sinopse',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function contents()
    {
        return $this->hasMany(ReviewContent::class, 'review_id');
    }
}
