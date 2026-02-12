<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class PollOption extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'polls_options';
    
    protected $fillable = [
        'poll_id',
        'option',
        'votes',
    ];

    protected $hidden = [
        'poll_id'
    ];

    protected $casts = [
        'votes' => 'integer',
    ];
}
