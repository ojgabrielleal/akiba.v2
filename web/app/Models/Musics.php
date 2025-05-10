<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Musics extends Model
{
    protected $table = 'musics';

    protected $fillable = [
        'image',
        'production',
        'singer',
        'music',
        'album',
        'cover',
        'max_solicitation'
    ];

    /**
     * Relationship with 'ListenersRequests' model
     */
    public function listenersRequests()
    {
        return $this->hasMany(ListenersRequests::class, 'music_id');
    }
}
