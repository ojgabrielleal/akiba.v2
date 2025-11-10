<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    protected $table = 'polls_options';

    protected $fillable = [
        'poll_id',
        'option',
        'votes',
    ];

    protected $hidden = [
        'poll_id'
    ];

    protected $casts = [
        'votes' => 'integer',
    ];
}
