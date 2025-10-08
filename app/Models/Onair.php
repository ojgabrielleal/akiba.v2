<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Onair extends Model
{
    protected $table = 'onair';

    protected $fillable = [
        'program_id',
        'program_type',
        'category',
        'is_live',
        'phrase',
        'image',
        'listener_request_status',
        'listener_request_total'
    ];

    protected $hidden = [
        'program_id'
    ];
    
    /**
     * Relationship from model 'Shows' and 'AutoDJ'
     */
    public function program()
    {
        return $this->morphTo();
    }

    /**
     * Relationship from model 'ListenersRequests'
     */
    public function listenersRequests()
    {
        return $this->hasMany(ListenerRequest::class);
    }
}
