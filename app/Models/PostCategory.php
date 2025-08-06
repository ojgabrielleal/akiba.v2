<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $table = 'posts_categories';

    protected $fillable = [
        'post_id',
        'category_name',
    ];

    protected $hidden = [
        'post_id'
    ];

    /**
     * Relationship with the 'Posts' model.
     */
    public function posts()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

}
