<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'user_id',
        'deadline',
        'content',
        'completed'
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'completed' => 'boolean',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $appends = ["deadline_status"];

    /**
     * Accessor for deadline status
     */
    public function getDeadlineStatusAttribute()
    {
        $deadline = Carbon::parse($this->attributes['deadline']);
        $now = Carbon::now();

        if($deadline->diffInDays($now) <= 1){
            return 'due_soon';
        }
    }

    /**
     * Mutator for content
     */
    public function getDeadlineAttribute($value)
    {
        return Carbon::parse($value)->format('d/m');
    }

    /**
     * Relationship with 'User' model
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
