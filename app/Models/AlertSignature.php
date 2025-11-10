<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertSignature extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
