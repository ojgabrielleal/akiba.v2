<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewContent extends Model
{
    protected $table = 'reviews_contents';

    protected $fillable = [
        'user_id',
        'review_id',
        'content',
    ];

    /**
     * Relationship with the 'Users' model.
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with the 'Reviews' model.
     */
    public function reviews()
    {
        return $this->belongsTo(Review::class);
    }
}
