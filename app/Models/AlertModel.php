<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertModel extends Model
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
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    /**
     * Relationship with the 'AlertSignature' model.
     */
    public function signatures()
    {
        return $this->hasMany(AlertSignatureModel::class, 'alert_id');
    }
}
