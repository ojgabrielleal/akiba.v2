<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersPermissions extends Model
{
    protected $table = 'users_permissions';

    protected $fillable = [
        'user_id',
        'permission',
    ];

    /**
     * Relationship from model 'Users'
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
