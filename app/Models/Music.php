<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Music extends Model
{
    use HasFactory;

    protected $table = 'musics';

    protected $fillable = [
        'type',
        'production',
        'image',
        'artist',
        'name',
        'in_ranking',
        'image_ranking',
        'song_request_count',
    ];

    /**
     * Query scopes for this model.
     *
     * These methods define reusable query filters that can be
     * applied to Eloquent queries (e.g., active()).
     */
    public function scopeRanking($query)
    {
        return $query->where('in_ranking', true);
    }
}
