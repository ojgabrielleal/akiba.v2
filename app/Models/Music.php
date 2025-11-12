<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $table = 'musics';

    protected $fillable = [
        'type',
        'production',
        'image',
        'artist',
        'name',
        'is_ranking',
        'image_ranking',
        'listener_request_total',
    ];
}
