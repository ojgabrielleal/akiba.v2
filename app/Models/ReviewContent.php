<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewContent extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'review_id',
        'content',
    ];

    protected $hidden = [
        'user_id',
        'review_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
