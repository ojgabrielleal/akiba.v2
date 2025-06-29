<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistBattle extends Model
{
    protected $table = 'playlists_battles';

    protected $fillable = [
        'day',
        'image',
    ];
}
