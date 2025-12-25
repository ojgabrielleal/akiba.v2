<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    protected $fillable = [
        'user_id',
        'is_activity',
        'activity_limit',
        'title',
        'content',
    ];

    protected $casts = [
        'activity_limit' => 'date',
        'is_activity' => 'boolean',
    ];

    protected $hidden = [
        'user_id',
    ];
    
    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function confirmations()
    {
        return $this->hasMany(ActivityConfirmation::class, 'activity_id');
    }

}
