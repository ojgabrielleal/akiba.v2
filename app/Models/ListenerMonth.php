<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListenerMonth extends Model
{
    protected $table = 'listener_month';

    protected $fillable = [
        'name',
        'avatar',
        'address',
        'favorite_show',
        'requests_total',
    ];
}
