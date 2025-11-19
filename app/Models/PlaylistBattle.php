<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlaylistBattle extends Model
{
    use HasFactory;

    protected $table = 'playlist_battle';
    
    protected $fillable = [
        'day',
        'image',
    ];

    protected $casts = [
        'day' => 'integer'
    ];
}
