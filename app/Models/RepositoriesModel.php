<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepositoryModel extends Model
{
    protected $table = 'repositories';

    protected $fillable = [
        'image',
        'file',
        'category',
        'name',
    ];
}
