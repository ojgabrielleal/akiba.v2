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

    protected $hidden = [
        'onair_id',
        'music_id'
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
    public function music()
    {
        return $this->belongsTo(Music::class, 'music_id');
    }
}
