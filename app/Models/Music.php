<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Music extends Model
{
    use HasFactory;

    protected $table = 'musics';
    
    protected $fillable = [
        'type',
        'production',
        'image',
        'artist',
        'name',
        'is_ranking',
        'image_ranking',
        'song_request_total',
    ];
}
