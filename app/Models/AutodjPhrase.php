<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AutoDJPhrase extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'auto_dj_id',
        'image',
        'phrase',
    ];

    protected $hidden = [
        'auto_dj_id'
    ];
}
