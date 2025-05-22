<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusicsModel extends Model
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
        return $this->hasMany(ListenersRequestsModel::class, 'music_id');
    }
}
