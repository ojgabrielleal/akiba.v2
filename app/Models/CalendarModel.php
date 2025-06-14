<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarModel extends Model
{
    protected $table = 'calendar';

    protected $fillable = [
        'user_id',
        'hour',
        'day',
        'category',
        'content',
    ];

    protected $casts = [
        'hour' => 'time',
    ];

    /**
     * Relationship with the 'Users' model.
     */
    public function users()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
