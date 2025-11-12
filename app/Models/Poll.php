<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $table = 'polls';

    protected $fillable = [
        'is_active',
        'question',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pollOptions()
    {
        return $this->hasMany(PollOption::class);
    }
}
