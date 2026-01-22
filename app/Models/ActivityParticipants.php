<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityParticipants extends Model
{
    use HasFactory;

    protected $table = 'activities_participants';
    
    protected $fillable = [
        'user_id',
        'activity_id',
    ];

    protected $hidden = [
        'user_id',
        'activity_id',
    ];

    public function confirmer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
