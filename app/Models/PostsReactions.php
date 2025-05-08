<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostsReactions extends Model
{
    protected $table = 'posts_reactions';

    protected $fillable = [
        'post_id',
        'reaction_type',
    ];

    /**
     * Relationship with the 'Posts' model.
     */
    public function posts()
    {
        return $this->belongsTo(Posts::class, 'post_id');
    }
}
