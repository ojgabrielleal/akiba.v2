<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'slug',
        'cover',
        'image',
        'title',
        'sinopse',
    ];

    protected $appends = ['authors', 'styles', 'editable'];

    /**
     * Get the authors for the review.
     */
    public function getAuthorsAttribute()
    {
        return $this->reviews()->with('user:id,slug,nickname')->get()
            ->pluck('user')
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'slug' => $user->slug,
                    'nickname' => $user->nickname,
                ];
            });
    }

    /**
     * Set accessor 'styles' in response
     */
    public function getStylesAttribute()
    {
        return [
            "bg" => 'var(--color-blue-skywave)'
        ];
    }

    /**
     * Set accessor 'editable' in response
     */
    public function getEditableAttribute()
    {
        return true;
    }

    /**
     * Relationship with the 'ReviewsContents' model.
     */
    public function reviews()
    {
        return $this->hasMany(ReviewContent::class);
    }
}
