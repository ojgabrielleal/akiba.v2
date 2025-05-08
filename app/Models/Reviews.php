<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'image',
        'title',
        'sinopse',
    ];

    /**
     * Relationship with the 'ReviewsContents' model.
     */
    public function reviewsContents()
    {
        return $this->hasMany(ReviewsContents::class);
    }

}
