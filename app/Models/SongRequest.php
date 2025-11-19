<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SongRequest extends Model
{
    use HasFactory;

    protected $table = 'songs_requests';
    
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
        return $this->belongsTo(Onair::class, 'onair_id');
    }
    
    public function music()
    {
        return $this->belongsTo(Music::class, 'music_id');
    }
}
