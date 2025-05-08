<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerts extends Model
{
    protected $table = 'alerts';

    protected $fillable = [
        'user_id',
        'content',
    ];

    /**
     * Relationship with the 'Users' model.
     */
    public function users()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    /**
     * Relationship with the 'AlertsSignatures' model.
     */
    public function alertsSignatures()
    {
        return $this->hasMany(AlertsSignatures::class, 'alert_id');
    }
}
