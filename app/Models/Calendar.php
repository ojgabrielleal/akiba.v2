<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calendar extends Model
{
    use HasFactory;

    protected $table = 'calendar';
    
    protected $fillable = [
        'is_active',
        'user_id',
        'activity_id',
        'time',
        'date',
        'type',
        'content',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'date' => 'date:Y-m-d',
        'time' => 'date:h:i',
    ];

    protected $hidden = [
        'user_id',
        'activity_id',
    ];

    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

}
