<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Onair extends Model
{
    use HasFactory;

    protected $table = 'onair';
    
    protected $fillable = [
        'is_playlist',
        'show_id',
        'show_type',
        'phrase',
        'type',
        'image',
        'allows_songs_requests',
        'song_request_count'
    ];

    protected $casts = [
        'is_playlist' => 'boolean'
    ];

    protected $hidden = [
        'show_id'
    ];

    public function show()
    {
        return $this->morphTo();
    }
}
