<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollsModel extends Model
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
        return $this->hasMany(PollsOptionsModel::class, 'poll_id');
    }
}
