<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    protected $table = 'podcasts';

    protected $fillable = [
        'slug',
        'is_active',
        'user_id',
        'image',
        'season',
        'episode',
        'title',
        'summary',
        'description',
        'audio'
    ];

    /**
     * Relationship with 'Users' model
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
