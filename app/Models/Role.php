<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'label',
        'name',
        'description'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_pivot', 'role_id', 'permission_id');
    }
}
