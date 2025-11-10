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
        'listener_ip',
        'address',
        'message',
        'status'
    ];

    protected $hidden = [
        'onair_id',
        'music_id'
    ];

    public function onair()
    {
        return $this->belongsTo(Onair::class, 'onair_id');
    }
    
    public function music()
    {
        return $this->belongsTo(Music::class, 'music_id');
    }
}
