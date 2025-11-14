<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListenerMonth extends Model
{
    use HasFactory;
    
    protected $table = 'listener_month';

    protected $fillable = [
        'name',
        'avatar',
        'address',
        'favorite_show',
        'requests_total',
    ];
}
