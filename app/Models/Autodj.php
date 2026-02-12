<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class AutoDJ extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'autodj';
    
    protected $fillable = [
        'user_id',
        'name',
        'image',
    ];

    protected $hidden = [
        'user_id',
    ];

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function host()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function phrases()
    {
        return $this->hasMany(AutoDJPhrase::class, 'autodj_id');
    }
    
}
