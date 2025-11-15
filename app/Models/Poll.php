<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poll extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'is_active',
        'question',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pollOption()
    {
        return $this->hasMany(PollOption::class);
    }
}
