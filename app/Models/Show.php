<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Show extends Model
{
    use HasFactory;

    protected $table = 'shows';
    
    protected $fillable = [
        'is_active',
        'user_id',
        'slug',
        'name',
        'image',
        'is_all',
        'has_schedule'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $hidden = [
        'user_id',
    ];

    public function showSchedule()
    {
        return $this->hasMany(ShowSchedule::class, 'show_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
