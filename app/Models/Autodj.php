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

    protected $hidden = [
        'user_id',
    ];

    /**
     * Relationship from model 'AutodjPhrases'
     */
    public function AutodjPhrase()
    {
        return $this->hasMany(AutodjPhrase::class);
    }

    /**
     * Relationship from model 'Users'
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship from model 'Onair'
     */
    public function onair()
    {
        return $this->morphMany(Onair::class, 'program');
    }
}
