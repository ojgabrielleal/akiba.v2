<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'slug',
        'cover',
        'image',
        'title',
        'sinopse',
    ];

    /**
     * Relationship with the 'ReviewsContents' model.
     */
    public function reviewContent()
    {
        return $this->hasMany(ReviewContent::class);
    }
}
