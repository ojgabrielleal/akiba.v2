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

    /**
     * Relationship with the 'Users' model.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship with the 'AlertSignature' model.
     */
    public function signatures()
    {
        return $this->hasMany(AlertSignature::class, 'alert_id');
    }
}
