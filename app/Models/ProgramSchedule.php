<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramSchedule extends Model
{
    protected $table = 'program_schedule';

    protected $fillable = [
        'show_id',
        'day',
        'time',
    ];

    /**
     * Relationship with the 'Shows' model.
     */
    public function show()
    {
        return $this->belongsTo(Show::class);
    }
}
