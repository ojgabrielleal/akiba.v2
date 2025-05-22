<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasksModel extends Model
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

    /**
     * Relationship with 'User' model
     */
    public function users()
    {
        return $this->belongsTo(UsersModel::class, 'user_id');
    }
}
