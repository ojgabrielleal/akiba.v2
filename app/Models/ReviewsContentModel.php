<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewsContentsModel extends Model
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
        return $this->belongsTo(UsersModel::class);
    }

    /**
     * Relationship with the 'Reviews' model.
     */
    public function reviews()
    {
        return $this->belongsTo(ReviewsModel::class);
    }
}
