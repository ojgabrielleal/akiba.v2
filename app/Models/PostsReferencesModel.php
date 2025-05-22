<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostsReferencesModel extends Model
{
    protected $table = 'posts_references';

    protected $fillable = [
        'post_id',
        'name',
        'url',
    ];

    /**
     * Relationship with the 'Posts' model.
     */
    public function posts()
    {
        return $this->belongsTo(PostsModel::class, 'post_id');
    }
}
