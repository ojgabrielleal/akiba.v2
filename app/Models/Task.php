<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    
    protected $fillable = [
        'is_active',
        'user_id',
        'is_completed',
        'title',
        'deadline',
        'content',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'deadline' => 'date',
        'is_completed' => 'boolean',
    ];

    protected $hidden = [
        'user_id',
    ];

    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
