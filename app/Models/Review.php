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

    public function reviewContent()
    {
        return $this->hasMany(ReviewContent::class);
    }
}
