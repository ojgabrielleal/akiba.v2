<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostsCategoriesModel extends Model
{
    protected $table = 'posts_categories';

    protected $fillable = [
        'post_id',
        'category_name',
    ];

    /**
     * Relationship with the 'Posts' model.
     */
    public function posts()
    {
        return $this->belongsTo(PostsModel::class, 'post_id');
    }

}
