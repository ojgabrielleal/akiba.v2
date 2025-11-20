<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AutoDJ extends Model
{
    use HasFactory;

    protected $table = 'autodj';
    
    protected $fillable = [
        'user_id',
        'name',
        'image',
    ];

    protected $hidden = [
        'user_id',
    ];
    
    public function autoDJPhrase()
    {
        return $this->hasMany(AutoDJPhrase::class, 'autodj_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
