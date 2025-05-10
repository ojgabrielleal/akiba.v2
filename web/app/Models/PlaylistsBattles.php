<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistsBattles extends Model
{
    protected $table = 'playlists_battles';

    protected $fillable = [
        'day',
        'image',
    ];
}
