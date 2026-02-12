<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\HasUuid;

class Task extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'tasks';

    protected $fillable = [
        'is_active',
        'user_id',
        'is_completed',
        'title',
        'deadline',
        'content',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'deadline' => 'date:d/m',
        'is_completed' => 'boolean',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $appends = ['is_over', 'is_due'];

    protected function isOver(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->is_complete) {
                    return false;
                }

                $deadline = $this->deadline;
                return $deadline->isPast();
            }
        );
    }

    protected function isDue(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->is_complete) {
                    return false;
                }

                $deadline = $this->deadline;
                return $deadline->between(today(), today()->addDays(7));
            }
        );
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

    public function scopeIncompleted($query)
    {
        return $query->where('is_completed', false);
    }

    public function scopeMine($query)
    {
        return $query->where('user_id', Auth::id());
    }

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */
    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
