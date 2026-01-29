<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewContent extends Model
{
    use HasFactory;

    protected $table = 'reviews_contents';

    protected $fillable = [
        'user_id',
        'review_id',
        'content',
    ];

    protected $hidden = [
        'user_id',
        'review_id'
    ];

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
