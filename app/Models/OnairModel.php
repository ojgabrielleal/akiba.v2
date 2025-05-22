<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnairModel extends Model
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
        return $this->belongsTo(ShowsModel::class);
    }

    /**
     * Relationship from model 'Autodj'
     */
    public function autodj()
    {
        return $this->belongsTo(AutodjModel::class);
    }

    /**
     * Relationship from model 'OnairControl'
     */
    public function onairControl()
    {
        return $this->hasMany(OnairControlsModel::class);
    }

    /**
     * Relationship from model 'ListenersRequests'
     */
    public function listenersRequests()
    {
        return $this->hasMany(ListenersRequests::class);
    }
}
