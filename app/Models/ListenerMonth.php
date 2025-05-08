<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListenerMonth extends Model
{
    protected $table = 'listener_month';

    protected $fillable = [
        'image',
        'listener_name',
        'address',
        'favorite_program',
        'quantity_of_requests',
    ];
}
