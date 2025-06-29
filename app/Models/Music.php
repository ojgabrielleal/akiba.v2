<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
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
        return $this->hasMany(ListenerRequest::class, 'music_id');
    }
}
