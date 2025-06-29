<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'image',
        'slug',
        'title',
        'content',
        'cover',
        'status',
    ];

    /**
     * Relationship with the 'Users' model.
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship with the 'PostsReferences' model.
     */
    public function postsReferences()
    {
        return $this->hasMany(PostReference::class, 'post_id');
    }

    /**
     * Relationship with the 'PostsReactions' model.
     */
    public function postsReactions()
    {
        return $this->hasMany(PostReaction::class, 'post_id');
    }

    /**
     * Relationship with the 'PostsCategories' model.
     */
    public function postsCategories()
    {
        return $this->hasMany(PostCategory::class, 'post_id');
    }
}
