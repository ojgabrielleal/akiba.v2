<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostReaction extends Model
{
    protected $table = 'posts_reactions';

    protected $fillable = [
        'post_id',
        'reaction_type',
    ];
}
