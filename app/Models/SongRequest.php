<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongRequest extends Model
{
    protected $table = 'song_requests';

    protected $fillable = [
        'is_played',
        'onair_id',
        'music_id',
        'ip',
        'name',
        'address',
        'message',
    ];

    protected $hidden = [
        'onair_id',
        'music_id'
    ];

    protected $casts = [
        'is_played' => 'boolean'
    ];

    public function onair()
    {
        return $this->belongsTo(Onair::class);
    }
    
    public function music()
    {
        return $this->belongsTo(Music::class);
    }
}
