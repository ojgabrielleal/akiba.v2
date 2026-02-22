<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Review extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'reviews';

    protected $fillable = [
        'uuid',
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

    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => [
                'title' => $value,
                'slug' => Str::slug($value),
            ],
        );
    }

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
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function reviews()
    {
        return $this->hasMany(ReviewContent::class, 'review_id');
    }
}
