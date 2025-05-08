<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertsSignatures extends Model
{
    protected $table = 'alerts_signatures';

    protected $fillable = [
        'user_id',
        'alert_id',
    ];

    /**
     * Relationship with 'Users' model.
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with 'Alerts' model.
     */
    public function alerts()
    {
        return $this->belongsTo(Alerts::class);
    }
}
