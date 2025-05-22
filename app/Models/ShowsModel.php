<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowsModel extends Model
{
    protected $table = 'shows';
    
    protected $fillable = [
        'user_id',
        'slug',
        'name',
        'image',
        'category',
    ];

    /**
     * Relationship from model 'Users'
     */
    public function users()
    {
        return $this->belongsTo(UsersModel::class);
    }

    /**
     * Relationship from model 'Onair'
     */
    public function onair()
    {
        return $this->hasMany(OnairModel::class);
    }
}
