<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repository extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'is_active',
        'image',
        'url',
        'type',
        'name',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
