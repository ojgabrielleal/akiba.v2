<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListenerRequest extends Model
{
    protected $table = 'listeners_requests';

    protected $fillable = [
        'onair_id',
        'music_id',
        'listener',
        'address',
        'message',
        'status'
    ];

    /**
     * Relationship with 'Onair' model
     */
    public function onair()
    {
        return $this->belongsTo(Onair::class, 'onair_id');
    }

    /**
     * Relationship with 'Musics' model
     */
    public function musics()
    {
        return $this->belongsTo(Music::class, 'music_id');
    }
}
