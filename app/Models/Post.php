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

    protected $hidden = [
        'user_id',
    ];

    /**
     * Relationship with the 'Users' model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship with the 'PostsReferences' model.
     */
    public function postReferences()
    {
        return $this->hasMany(PostReference::class, 'post_id');
    }

    /**
     * Relationship with the 'PostsReactions' model.
     */
    public function postReactions()
    {
        return $this->hasMany(PostReaction::class, 'post_id');
    }

    /**
     * Relationship with the 'PostsCategories' model.
     */
    public function postCategories()
    {
        return $this->hasMany(PostCategory::class, 'post_id');
    }
}
