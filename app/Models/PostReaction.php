<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostReaction extends Model
{
    use HasFactory;

    protected $table = 'posts_reactions';
    
    protected $fillable = [
        'post_id',
        'type',
    ];

    protected $hidden = [
        'post_id'
    ];
}
