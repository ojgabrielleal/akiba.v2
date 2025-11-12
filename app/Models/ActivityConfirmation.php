<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityConfirmation extends Model
{
    protected $table = 'activities_confirmations';

    protected $fillable = [
        'user_id',
        'activities_id',
    ];

    protected $hidden = [
        'user_id',
        'activities_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
