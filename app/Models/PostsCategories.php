<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostsCategories extends Model
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
        return $this->belongsTo(Posts::class, 'post_id');
    }

}
