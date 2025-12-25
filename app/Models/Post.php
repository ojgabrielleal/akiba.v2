<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    
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

    public function references()
    {
        return $this->hasMany(PostReference::class, 'post_id');
    }
    
    public function reactions()
    {
        return $this->hasMany(PostReaction::class, 'post_id');
    }
    
    public function categories()
    {
        return $this->hasMany(PostCategory::class, 'post_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
