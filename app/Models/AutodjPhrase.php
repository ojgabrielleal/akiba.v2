<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoDJPhrase extends Model
{
    protected $table = 'autodj_phrases';

    protected $fillable = [
        'autodj_id',
        'image',
        'phrase',
    ];

    protected $hidden = [
        'autodj_id'
    ];
}
