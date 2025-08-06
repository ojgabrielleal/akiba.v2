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

    protected $appends = [
        'enable_confirm',
    ];

    protected static function booted()
    {
        static::addGlobalScope('orderByCreated', function ($query) {
            $query->orderBy('created_at', 'desc');
        });
    }

    /**
     * Set accessor 'enable_confirm' in response
     */
    function getEnableConfirmAttribute()
    {
        return true;
    }

    /**
     * Relationship with the 'Users' model.
     */
    public function user()
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
