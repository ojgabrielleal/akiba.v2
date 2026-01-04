<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    protected $fillable = [
        'user_id',
        'is_activity',
        'activity_limit',
        'title',
        'content',
    ];

    protected $casts = [
        'activity_limit' => 'date',
        'is_activity' => 'boolean',
    ];

    protected $hidden = [
        'user_id',
    ];

    /**
     * Booted to verify limit from activity
     */
    protected static function booted()
    {
        static::addGlobalScope('valid', function (Builder $builder) {
            $builder->where(function ($q) {
                $q->whereNull('activity_limit')
                  ->orWhereDate('activity_limit', '>=', today());
            });
        });
    }
    
    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function confirmations()
    {
        return $this->hasMany(ActivityConfirmation::class, 'activity_id');
    }

}
