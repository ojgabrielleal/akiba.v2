<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AutoDJ extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'autodj';

    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'image',
    ];

    protected $hidden = [
        'user_id',
    ];

    /**
     * Determine the columns that should receive a unique identifier.
     *
     * This method specifies that the 'uuid' column should be automatically 
     * generated as a sortable, unique identifier when the model is created.
     *
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

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
