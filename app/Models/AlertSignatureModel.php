<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertSignatureModel extends Model
{
    protected $table = 'alerts_signatures';

    protected $fillable = [
        'user_id',
        'alert_id',
    ];

    protected $hidden = [
        'user_id',
        'alert_id',
    ];

    /**
     * Relationship with 'Users' model.
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }

    /**
     * Relationship with 'Alert' model.
     */
    public function alert()
    {
        return $this->belongsTo(AlertModel::class);
    }
}
