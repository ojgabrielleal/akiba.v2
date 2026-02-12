<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class AutoDJPhrase extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'autodj_phrases';
    
    protected $fillable = [
        'autodj_id',
        'image',
        'phrase',
    ];

    protected $hidden = [
        'autodj_id'
    ];
}
