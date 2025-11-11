<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'is_active',
        'user_id',
        'image',
        'slug',
        'title',
        'content',
        'cover',
        'status',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $hidden = [
        'user_id',
    ];

    public function postReferences()
    {
        return $this->hasMany(PostReference::class, 'post_id');
    }
    
    public function postReactions()
    {
        return $this->hasMany(PostReaction::class, 'post_id');
    }
    
    public function postCategories()
    {
        return $this->hasMany(PostCategory::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
