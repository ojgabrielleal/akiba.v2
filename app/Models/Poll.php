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

    public function pollOptions()
    {
        return $this->hasMany(PollOption::class);
    }
}
