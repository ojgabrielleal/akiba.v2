<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autodj extends Model
{
    protected $table = 'autodj';

    protected $fillable = [
        'user_id',
        'name',
        'image',
    ];

    /**
     * Relationship from model 'AutodjPhrases'
     */
    public function autodjPhrases()
    {
        return $this->hasMany(AutodjPhrases::class);
    }
    
    /**
     * Relationship from model 'Users'
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship from model 'Onair'
     */
    public function onair()
    {
        return $this->hasMany(Onair::class);
    }
    
}
