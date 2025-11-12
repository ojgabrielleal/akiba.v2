<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'is_active',
        'user_id',
        'deadline',
        'content',
        'completed'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'deadline' => 'datetime',
        'completed' => 'boolean',
    ];

    protected $hidden = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
