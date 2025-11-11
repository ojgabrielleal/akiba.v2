<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramSchedule extends Model
{
    protected $table = 'shows_schedule';

    protected $fillable = [
        'show_id',
        'day',
        'time',
    ];

    protected $hidden = [
        'show_id',
    ];
}
