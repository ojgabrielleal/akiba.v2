<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $table = 'users';

    protected $fillable = [
        'uuid',
        'is_active',
        'slug',
        'username',
        'password',
        'name',
        'nickname',
        'gender',
        'avatar',
        'birthday',
        'city',
        'state',
        'country',
        'bibliography',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_active' => 'boolean',
        'birthday' => 'date',
    ];

    protected function nickname(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => [
                'nickname' => $value,
                'slug' => Str::slug($value),
            ],
        );
    }

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
     * Query scopes for this model.
     *
     * These methods define reusable query filters that can be
     * applied to Eloquent queries (e.g., active()).
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function socials()
    {
        return $this->hasMany(UserSocial::class, 'user_id');
    }

    public function preferences()
    {
        return $this->hasMany(UserPreference::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_pivot', 'user_id', 'role_id');
    }
}
