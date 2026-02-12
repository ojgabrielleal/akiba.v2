<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class PlaylistBattle extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'playlist_battle';
    
    protected $fillable = [
        'day',
        'image',
    ];

    protected $casts = [
        'day' => 'integer'
    ];
}
