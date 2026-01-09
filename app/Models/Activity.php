<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    protected $fillable = [
        'allows_confirmations',
        'user_id',
        'limit',
        'title',
        'content',
    ];

    protected $casts = [
        'allows_confirmations' => 'boolean',
        'limit' => 'date:Y-m-d',
    ];

    protected $hidden = [
        'user_id',
    ];

    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function confirmations()
    {
        return $this->hasMany(ActivityConfirmation::class, 'activity_id');
    }

}
