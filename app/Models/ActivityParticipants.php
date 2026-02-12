<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class ActivityParticipants extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'activities_participants';
    
    protected $fillable = [
        'user_id',
        'activity_id',
    ];

    protected $hidden = [
        'user_id',
        'activity_id',
    ];

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function confirmer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
