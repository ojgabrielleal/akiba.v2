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

    protected $appends = ['styles', 'editable'];

    protected static function booted()
    {
        static::addGlobalScope('orderByCreated', function ($query) {
            $query->orderBy('created_at', 'desc');
        });
    }

    /**
     * Set accessor 'styles' in response
    */
    public function getStylesAttribute()
    {
        $status = [
            "published"=> "var(--color-blue-skywave)",
            "sketch"=> "var(--color-green-forest)",
            "revision"=> "var(--color-orange-amber)"
        ];

        return [
            "bg" => $status[$this->status] ?? 'var(--color-blue-skywave)'
        ];
    }

    /**
     * Set accessor 'editable' in response
    */
    public function getEditableAttribute()
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        if ($user->permissions_keys->contains('administrator')) {
            return true;
        }
        
        return $this->user_id == $user->id;
    }


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
    public function references()
    {
        return $this->hasMany(PostReference::class, 'post_id');
    }

    /**
     * Relationship with the 'PostsReactions' model.
     */
    public function reactions()
    {
        return $this->hasMany(PostReaction::class, 'post_id');
    }

    /**
     * Relationship with the 'PostsCategories' model.
     */
    public function categories()
    {
        return $this->hasMany(PostCategory::class, 'post_id');
    }
}
