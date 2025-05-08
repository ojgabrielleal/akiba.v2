<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Onair extends Model
{
    protected $table = 'onair';
    
    protected $fillable = [
        'user_id',
        'show_id',
        'category',
    ];

    /**
     * Relationship from model 'Shows'
     */
    public function shows()
    {
        return $this->belongsTo(Shows::class);
    }

    /**
     * Relationship from model 'Autodj'
     */
    public function autodj()
    {
        return $this->belongsTo(Autodj::class);
    }

    /**
     * Relationship from model 'OnairControl'
     */
    public function onairControl()
    {
        return $this->hasMany(OnairControls::class);
    }

    /**
     * Relationship from model 'ListenersRequests'
     */
    public function listenersRequests()
    {
        return $this->hasMany(ListenersRequests::class);
    }
}
