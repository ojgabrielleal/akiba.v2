<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polls extends Model
{
    protected $table = 'polls';

    protected $fillable = [
        'question',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function pollsOptions()
    {
        return $this->hasMany(PollsOptions::class, 'poll_id');
    }
}
