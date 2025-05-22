<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollsOptionsModel extends Model
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
        return $this->belongsTo(PollsModel::class, 'poll_id');
    }
}
