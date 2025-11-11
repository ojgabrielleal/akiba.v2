<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePivot extends Model
{
    protected $table = 'roles_pivot';

    protected $fillable = [
        'user_id',
        'role_id'
    ];
}
