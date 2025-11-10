<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autodj extends Model
{
    protected $table = 'autodj';

    protected $fillable = [
        'user_id',
        'name',
        'image',
    ];

    protected $hidden = [
        'user_id',
    ];
    
    public function autoDjPhrases()
    {
        return $this->hasMany(AutodjPhrase::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
