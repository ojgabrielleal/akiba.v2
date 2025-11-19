<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShowSchedule extends Model
{
    use HasFactory;

    protected $table = 'shows_schedules';
    
    protected $fillable = [
        'show_id',
        'day',
        'time',
    ];
    
    protected $casts = [
        'day' => 'integer'
    ];
    
    protected $hidden = [
        'show_id',
    ];

}
