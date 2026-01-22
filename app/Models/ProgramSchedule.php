<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgramSchedule extends Model
{
    use HasFactory;

    protected $table = 'programs_schedules';
    
    protected $fillable = [
        'program_id',
        'day',
        'time',
    ];
    
    protected $casts = [
        'day' => 'integer'
    ];
    
    protected $hidden = [
        'program_id',
    ];

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
    
}
