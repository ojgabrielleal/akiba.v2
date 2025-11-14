<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlaylistBattle extends Model
{
    use HasFactory;
    
    protected $table = 'playlists_battles';

    protected $fillable = [
        'day',
        'image',
    ];
}
