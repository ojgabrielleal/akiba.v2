<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
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
        return $this->hasMany(PollOption::class, 'poll_id');
    }
}
