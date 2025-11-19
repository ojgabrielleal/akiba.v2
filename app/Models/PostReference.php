<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostReference extends Model
{
    use HasFactory;

protected $table = 'posts_references';
    
    protected $fillable = [
        'post_id',
        'name',
        'url',
    ];

    protected $hidden = [
        'post_id'
    ];
}
