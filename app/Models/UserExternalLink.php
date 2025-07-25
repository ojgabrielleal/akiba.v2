<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExternalLink extends Model
{
    protected $table = 'users_externals_links';

    protected $fillable = [
        'user_id',
        'name',
        'url',
    ];


    /**
     * Relationship from model 'Users'
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
