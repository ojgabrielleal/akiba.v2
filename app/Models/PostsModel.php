<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostsModel extends Model
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
        return $this->belongsTo(UsersModel::class, 'user_id');
    }

    /**
     * Relationship with the 'PostsReferences' model.
     */
    public function postsReferences()
    {
        return $this->hasMany(PostsReferencesModel::class, 'post_id');
    }

    /**
     * Relationship with the 'PostsReactions' model.
     */
    public function postsReactions()
    {
        return $this->hasMany(PostsReactionsModel::class, 'post_id');
    }

    /**
     * Relationship with the 'PostsCategories' model.
     */
    public function postsCategories()
    {
        return $this->hasMany(PostsCategoriesModel::class, 'post_id');
    }

}
