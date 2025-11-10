<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $table = 'musics';

    protected $fillable = [
        'production',
        'artist',
        'music',
        'listener_request_total',
        'image',
        'image_ranking',
        'is_ranking',
        'type'
    ];
}
