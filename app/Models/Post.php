<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'is_active',
        'user_id',
        'image',
        'slug',
        'title',
        'content',
        'cover',
        'type'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $hidden = [
        'user_id',
    ];

    public function postReference()
    {
        return $this->hasMany(PostReference::class);
    }
    
    public function postReaction()
    {
        return $this->hasMany(PostReaction::class);
    }
    
    public function postCategory()
    {
        return $this->hasMany(PostCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
