<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionPivot extends Model
{
    protected $table = 'permissions_pivot';

    protected $fillable = [
        'permission_id',
        'role_id'
    ];
}
