<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityConfirmation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'activity_id',
    ];

    protected $hidden = [
        'user_id',
        'activity_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
