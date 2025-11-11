<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoDJ extends Model
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
    
    public function autoDJPhrases()
    {
        return $this->hasMany(AutodjPhrase::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
