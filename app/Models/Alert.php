<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $table = 'alerts';

    protected $fillable = [
        'user_id',
        'content',
    ];

    protected $hidden = [
        'user_id',
    ];
    
    public function alertSignature()
    {
        return $this->hasMany(AlertSignature::class, 'alert_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
