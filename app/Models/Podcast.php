<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Podcast extends Model
{
    use HasFactory;
    
    protected $table = 'podcasts';

    protected $fillable = [
        'is_active',
        'slug',
        'user_id',
        'title',
        'image',
        'season',
        'episode',
        'summary',
        'description',
        'audio'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
