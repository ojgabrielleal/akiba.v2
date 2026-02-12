<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class Role extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'roles';

    protected $fillable = [
        'label',
        'name',
        'description',
        'weight'
    ];

    protected $casts = [
        'weight' => 'integer'
    ];

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_pivot', 'role_id', 'permission_id');
    }
}
