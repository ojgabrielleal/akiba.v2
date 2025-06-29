<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    protected $table = 'polls_options';

    protected $fillable = [
        'poll_id',
        'option',
        'votes',
    ];

    protected $casts = [
        'votes' => 'integer',
    ];

    public function polls()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }
}
