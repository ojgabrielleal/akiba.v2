<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'user_id',
        'deadline',
        'content',
        'completed'
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'completed' => 'boolean',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $appends = ["due_soon", "styles"];

    protected static function booted()
    {
        static::addGlobalScope('orderByCreated', function ($query) {
            $query->orderBy('created_at', 'desc');
        });
    }

    /**
     * Set accessor 'deadline_status' in response
     */
    public function getDueSoonAttribute()
    {
        $deadline = Carbon::parse($this->attributes['deadline']);
        $now = Carbon::now();

        return $deadline->greaterThan($now) && $deadline->lessThanOrEqualTo($now->copy()->addDays(7));
    }

    /**
     * Set accessor 'styles' in response
     */
    public function getStylesAttribute()
    {
        $deadline = Carbon::parse($this->attributes['deadline']);
        $now = Carbon::now();

        // Use diffInDays and check if it's 7 or less
        if ($deadline->greaterThan($now) && $deadline->lessThanOrEqualTo($now->copy()->addDays(7))) {
            return [
                "bg" => "var(--color-orange-amber)",
                "bg_date" => [
                    "title" => "var(--color-red-crimson)",
                    "date" => "var(--color-blue-indigo)"
                ]
            ];
        } else {
            return [
                "bg" => "var(--color-blue-skywave)",
                "bg_date" => [
                    "title" => "var(--color-blue-indigo)",
                    "title_text_color" => "var(--color-neutral-aurora)",
                    "date" => "var(--color-neutral-aurora)",
                    "date_text_color" => "var(--color-blue-indigo)"
                ]
            ];
        }
    }

    /**
     * Mutator for content
     */
    public function getDeadlineAttribute($value)
    {
        return Carbon::parse($value)->format('d/m');
    }

    /**
     * Relationship with 'User' model
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
