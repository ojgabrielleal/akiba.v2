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

    protected $hidden = [
        'user_id',
        'review_id'
    ];

    /**
     * Relationship with the 'Users' model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
