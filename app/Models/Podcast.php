<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    protected $table = 'podcasts';

    protected $fillable = [
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
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
