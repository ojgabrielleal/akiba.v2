<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class PostReference extends Model
{
    use HasFactory, HasUuid;

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
