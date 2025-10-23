<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $table = 'repositories';

    protected $fillable = [
        'is_active',
        'image',
        'file',
        'category',
        'name',
    ];
}
